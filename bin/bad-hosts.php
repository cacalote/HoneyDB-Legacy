<?php
$rs        = $db->CacheExecute(300, "SELECT remote_host, COUNT(remote_host) AS ip_count, MAX(date) AS last_seen FROM honeypy GROUP BY remote_host ORDER BY ip_count DESC;");
$bad_hosts = array();

foreach($rs as $row) {
	array_push($bad_hosts, array('remote_host'=>$row['remote_host'], 'count'=>$row['ip_count'], 'last_seen'=>$row['last_seen']));
}

header("Content-type: application/json");
echo json_encode($bad_hosts);
?>
