<?php
include 'validate.date.php';
include 'validate.service.php';
include 'validate.ip.php';
include 'validate.days.php';

$where       = '';
$where_count = 0;
$paramArray  = array();

if('all' != $s || 'all' != $i) {
	$where = 'WHERE ';

	if('all' != $s && 'all' != $i) {
		$where .= "service=? AND remote_host=?";
		array_push($paramArray, '[' . $s . ']', $i);
		$where_count++;
	} elseif('all' != $s) {
		$where .= "service=?";
		array_push($paramArray, '[' . $s . ']');
		$where_count++;
	} elseif('all' != $i) {
		$where .= "remote_host=?";
		array_push($paramArray, $i);
		$where_count++;
	}
	// else don't do nada
}

if('all' != $date) {
	if(0 == $where_count) {
		$where .= " WHERE";
		$where_count++;
	} else {
		$where .= " AND";
	}

	$where .= " date = ? ";
	array_push($paramArray, $date);
} else {
	if($days > 0) {
		if(0 == $where_count) {
			$where .= " WHERE";
			$where_count++;
		} else {
			$where .= " AND";
		}

		$where .= " date >= (CURDATE() - INTERVAL ? DAY) ";
		array_push($paramArray, $days);
	}
}

$rs = $db->Execute("SELECT date_time, event, data, bytes FROM honeypy $where ORDER BY date_time ASC;", $paramArray);

$eventArray = array();

foreach($rs as $row) {
	array_push($eventArray, $row);
}

header("Content-type: text/plain");
echo json_encode($eventArray);
?>
