<?php
include 'validate.service.php';
include 'validate.days.php';

$params  = array($days);
$rs      = $db->Execute("SELECT service, COUNT(service) AS service_count FROM honeypy WHERE date >= (CURDATE() - INTERVAL ? DAY) GROUP BY service ORDER BY service_count DESC LIMIT 10;", $params);
$ipArray = array();

foreach($rs as $row) {
	array_push($ipArray, $row);
}

header("Content-type: text/plain");
echo json_encode($ipArray);
?>
