<?php
$s = !isset($_GET['s']) ? $_GET['s'] = 'all' : trim($_GET['s']);
$i = !isset($_GET['i']) ? $_GET['i'] = '' : trim($_GET['i']);

if(false == filter_var($i, FILTER_VALIDATE_IP) && '' != $i) {
	echo 'i:Error, meh!';
	exit();
}

$paramArray = array();

if('all' != $s) {
	$where = '';
	if(filter_var($i, FILTER_VALIDATE_IP)) {
		$where = " AND remote_host=? ";
	}

	array_push($paramArray, $s, $i);

	$sql = "SELECT service, COUNT(service) AS service_count FROM honeypy WHERE service=?" . $where . "GROUP BY service ORDER BY service_count DESC;";

	$rs = $db->Execute($sql, $paramArray);
	
	$serviceArray = array();

	foreach($rs as $row) {
		array_push($serviceArray, $row);
	}

	header("Content-type: text/plain");
	echo json_encode($serviceArray);

} else {
	$where = '';
        if(filter_var($i, FILTER_VALIDATE_IP)) {
		$where = " WHERE remote_host=? ";

		array_push($paramArray, $i);
        }

	$rs = $db->Execute("SELECT service, COUNT(service) AS service_count FROM honeypy $where GROUP BY service ORDER BY service_count DESC;", $paramArray);

	$serviceArray = array();

	foreach($rs as $row) {
		array_push($serviceArray, $row);
	}

	header("Content-type: text/plain");
	echo json_encode($serviceArray);

}
?>
