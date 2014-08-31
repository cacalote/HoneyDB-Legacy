<?php
$rs = $db->Execute("SELECT remote_host, COUNT(remote_host) AS ip_count, MAX(date) AS last_seen FROM honeypy GROUP BY remote_host ORDER BY ip_count DESC;");

$ipArray = array();

foreach($rs as $row) {
	array_push($ipArray, array('remote_host'=>$row['remote_host'], 'count'=>$row['ip_count'], 'last_seen'=>$row['last_seen']));
}

header("Content-type: text/plain");
echo json_encode($ipArray);
?>
