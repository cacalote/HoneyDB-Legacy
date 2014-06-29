<?php
$rs = $db->Execute("SELECT remote_host, COUNT(remote_host) AS ip_count FROM honeypy GROUP BY remote_host ORDER BY ip_count DESC;");

$ipArray = array();

foreach($rs as $row) {
	array_push($ipArray, $row);
}

header("Content-type: text/plain");
echo json_encode($ipArray);
?>
