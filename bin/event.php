<?php
$s = !isset($_GET['s']) ? $_GET['s'] = '' : trim($_GET['s']);
$i = !isset($_GET['i']) ? $_GET['i'] = '' : trim($_GET['i']);

if(false == filter_var($i, FILTER_VALIDATE_IP) && '' != $i) {
	echo 'i:Error, meh!';
	exit();
}

$where = '';
$paramArray = array();

if($s != '' || $i != '') {
	$where = 'WHERE ';

	if(strlen(trim($s)) && strlen(trim($i))) {
		$where .= "service=? AND remote_host=?";
		array_push($paramArray, '[' . $s . ']', $i);
	} elseif(strlen(trim($s))) {
		$where .= "service=?";
		array_push($paramArray, '[' . $s . ']');
	} elseif(strlen(trim($i))) {
		$where .= "remote_host=?";
		array_push($paramArray, $i);
	}
	// else don't do nada
}

$rs = $db->Execute("SELECT date_time, event, data FROM honeypy $where ORDER BY date_time ASC;", $paramArray);

$eventArray = array();

foreach($rs as $row) {
	array_push($eventArray, $row);
}

header("Content-type: text/plain");
echo json_encode($eventArray);
?>
