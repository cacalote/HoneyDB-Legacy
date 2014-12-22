<?php
include 'validate.ip.php';

if(!strlen($SHODAN_API_KEY)) {
	echo 'k:Error, meh! If you need a Shodan API key go to https://developer.shodan.io/.';
	exit();
}

$json = file_get_contents('http://www.shodanhq.com/api/host?ip=' . $i . '&key=' . $SHODAN_API_KEY);
$obj  = json_decode($json);
$arr  = objectToArray($obj);

header("Content-type: text/plain");

echo 'Host names: ' . "\n";

foreach($arr['hostnames'] as $h) {
	echo "\t" . $h . "\n\n";
}

echo '<br>';
echo 'Ports and Banners:' . "\n";

foreach($arr['data'] as $d) {
	echo 'Port: ' . $d['port'] . " &nbsp; &nbsp; " . $d['last_update'] . "\n";
	echo 'Banner:' . "\n";
	echo '<pre>' . htmlentities(trim($d['banner'])) . "</pre>\n";
}

// use print_r($arr); to see all output from shodan
// credit for objectToArray function:
// http://www.if-not-true-then-false.com/2009/php-tip-convert-stdclass-object-to-multidimensional-array-and-convert-multidimensional-array-to-stdclass-object/
function objectToArray($d) {
	if (is_object($d)) {
		// Gets the properties of the given object
		// with get_object_vars function
		$d = get_object_vars($d);
	}       

	if (is_array($d)) {
		/*      
		* Return array converted to object
		* Using __FUNCTION__ (Magic constant)
		* for recursive call
		*/      
		return array_map(__FUNCTION__, $d);
	} else {  
		// Return array
		return $d;
	}       
}
?>
