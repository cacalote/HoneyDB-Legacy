<?php
include 'validate.ip.php';
include 'validate.service.php';
include 'validate.date.php';
include 'validate.days.php';

$where       = '';
$where_count = 0;
$paramArray  = array();

if('all' != $i) {
	push_array($paramArray, $i);
 
	if(strlen(trim($s))) {
		$where = " AND service=?";
		push_array($paramArray, '[' . $s . ']');
	}

	$rs = $db->Execute("SELECT remote_host, COUNT(remote_host) AS ip_count FROM honeypy WHERE remote_host=?  $where GROUP BY remote_host ORDER BY ip_count DESC;", $paramArray);

	$ipArray = array();

	foreach($rs as $row) {
			array_push($ipArray, $row);
	}

	header("Content-type: text/plain");
	echo json_encode($ipArray);

} else {
	// if a service is specified
	if('all' != $s) {
		if(0 == $where_count) {
			$where .= " WHERE";
			$where_count++;
		} else {
			$where .= " AND";
		}

		$where .= " service=?";
		array_push($paramArray, '[' . $s . ']');
	}

	// if a date is specified
	if('all' != $date) {
		if(0 == $where_count) {
			$where .= " WHERE";
			$where_count++;
		} else {
			$where .= " AND";
		}

		$where .= " date=?";
		array_push($paramArray, $date);
		
		$days = 0; // cancel out days filter
	}

	// if days are specified
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

	$rs = $db->Execute("SELECT remote_host, COUNT(remote_host) AS ip_count FROM honeypy " . $where . " GROUP BY remote_host ORDER BY ip_count DESC;", $paramArray);

	$ipArray = array();

	foreach($rs as $row) {
			array_push($ipArray, $row);
	}

	header("Content-type: text/plain");
	echo json_encode($ipArray);
}
?>
