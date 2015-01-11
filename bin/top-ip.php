<?php
include 'validate.days.php';

$params  = array($days);
$rs      = $db->CacheExecute(300, "SELECT remote_host, COUNT(remote_host) AS ip_count FROM honeypy WHERE date >= (CURDATE() - INTERVAL ? DAY) AND event='CONNECT' GROUP BY remote_host ORDER BY ip_count DESC LIMIT 10;", $params);
$ipArray = array();

foreach($rs as $row) {
	array_push($ipArray, $row);
}

header("Content-type: text/plain");
echo json_encode($ipArray);
?>
