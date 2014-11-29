<?php
// perform validation
if(isset($_GET['b'])) {
	if(false == filter_var($_GET['b'], FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^[a-z-]{1,15}$/')))) {
		echo 'b:Error. Meh!';
		exit();
	}
}

if(isset($_GET['days'])) {
	if(false == filter_var($_GET['days'], FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^[0-9]{1,3}$/')))) {
		echo 'days:Error. Meh!';
		exit();
	}
	
	$days = $_GET['days'];
} else {
	$days = 10;
}

$params = array($days);
$rs = $db->Execute("SELECT remote_host, COUNT(remote_host) AS ip_count FROM honeypy WHERE date >= (CURDATE() - INTERVAL ? DAY) GROUP BY remote_host ORDER BY ip_count DESC LIMIT 10;", $params);

$ipArray = array();
foreach($rs as $row) {
	array_push($ipArray, $row);
}

header("Content-type: text/plain");
echo json_encode($ipArray);
?>
