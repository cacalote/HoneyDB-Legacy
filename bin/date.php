<?php
$d = !isset($_GET['d']) ? 'all'  : trim($_GET['d']);
$v = !isset($_GET['v']) ? 'none' : trim($_GET['v']);

if(false == filter_var($d, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^[\w-\. ]{1,10}$/')))) {
	echo 'd:Error, meh!';
	exit();
}

if(false == filter_var($v, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^[\w]{1,7}$/')))) {
	echo 'v:Error, meh!';
	exit();
}

if(isset($_REQUEST['days'])) {
	$days = intval($_REQUEST['days']);
} else {
	$days = $DEFAULT_DAYS;
}

if('all' != $d && 'service' == $_GET['v']) {
	$params = array($d);
	$sql = "SELECT service, COUNT(service) AS service_count FROM honeypy WHERE date=? GROUP BY service ORDER BY service DESC;";
	$rs  = $db->Execute($sql, $params);

	foreach($rs as $row) {
		array_push($dateArray, $row);
	}

	header("Content-type: text/plain");
	echo json_encode($dateArray);

} elseif('all' != $d) {
	$sql = "SELECT remote_host, COUNT(remote_host) AS ip_count FROM honeypy WHERE date=? $where GROUP BY remote_host ORDER BY remote_host DESC;";
	$rs  = $db->Execute($sql, array($d));

	$dateArray = array();

	foreach($rs as $row) {
		array_push($dateArray, $row);
	}

	header("Content-type: text/plain");
	echo json_encode($dateArray);

} else {
	$params    = array($days);
	$rs        = $db->Execute("SELECT date, COUNT(date) AS date_count FROM honeypy GROUP BY date ORDER BY date DESC LIMIT ?;", $params);
	$dateArray = array();

	foreach($rs as $row) {
		array_push($dateArray, $row);
	}

	header("Content-type: text/plain");
	echo json_encode($dateArray);
}
?>
