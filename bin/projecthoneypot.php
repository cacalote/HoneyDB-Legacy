<?php
include 'validate.ip.php';

if(!strlen($PH_API_KEY)) {
	echo 'k:Error, meh! If you need a Project Honeypot API key go to http://www.projecthoneypot.org/httpbl_api.php.';
	exit();
}

$DAYS         = 1;
$THREAT       = 2;
$TYPE         = 3;
$type_array   = array(
		'0'=>'Search Engine',
		'1'=>'Suspicious',
		'2'=>'Harvester',
		'3'=>'Suspicous & Harvester',
		'4'=>'Comment Spammer',
		'5'=>'Suspicious & Comment Spammer',
		'6'=>'Harvester & Comment Spammer',
		'7'=>'Suspicious & Harvester & Comment Spammer'
		);
$server       = 'dnsbl.httpbl.org';
$dns_query    = $PH_API_KEY . '.' . implode('.', array_reverse(explode('.', $i))) . '.' . $server;
$dns_response = gethostbyname($dns_query);

header("Content-type: text/plain");

if($dns_query == $dns_response) {
	echo 'No Project Honeypot data found for this IP.' . "\n\n";
} else {

	$result = explode('.', $dns_response);

	echo 'Answer: ' . $dns_response . "\n";
	echo 'Days: ' . $result[$DAYS] . "\n";

	$threat_description = '';

	if($result[$THREAT] < 25) {
		$threat_description = 'Under 100';
	} elseif($result[$THEAT] < 50) {
		$threat_description = 'Under 10,000';
	} elseif($result[$THREAT] < 75) {
		$threat_description = 'Under 1,000,000';
	} else {
		$threat_description = 'Over 1,000,000';
	}

	echo 'Threat: ' . $result[$THREAT] . ' (' . $threat_description . ")\n";
	echo 'Type: ' . $type_array[$result[$TYPE]] . "\n\n";
}

echo '(<a target="_new" href="https://www.projecthoneypot.org/ip_' . $i . '">view more details</a>)';

?>
