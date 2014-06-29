<?php
$rs = $db->Execute("SELECT service, COUNT(service) AS service_count FROM honeypy GROUP BY service ORDER BY service_count DESC LIMIT 10;");

$ipArray = array();

foreach($rs as $row) {
	array_push($ipArray, $row);
}

header("Content-type: text/plain");
echo json_encode($ipArray);
?>
