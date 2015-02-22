<?php
$s = !isset($_GET['s']) ? $_GET['s'] = 'service-not-provided' : trim($_GET['s']);

include 'validate.service.php';

$rs           = $db->Execute("SELECT local_port FROM honeypy WHERE service=? LIMIT 1;", array($s));
$serviceArray = array();

foreach($rs as $row) {
	array_push($serviceArray, $row);
}

header("Content-type: text/plain");
echo json_encode($serviceArray);
?>
