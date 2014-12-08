<?php
include 'validate.services.php';
include 'validate.ip.php';

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

$rs = $db->Execute("SELECT date_time, event, data, bytes FROM honeypy $where ORDER BY date_time ASC;", $paramArray);

$eventArray = array();

foreach($rs as $row) {
	array_push($eventArray, $row);
}

header("Content-type: text/plain");
echo json_encode($eventArray);
?>
