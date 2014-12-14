<?php
include 'validate.service.php';
include 'validate.ip.php';
include 'validate.date.php';
include 'validate.days.php';

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
	$where       = '';
	$where_count = 0;

	// if a ip is specified
	if(filter_var($i, FILTER_VALIDATE_IP)) {
		if(0 == $where_count) {
			$where .= " WHERE";
			$where_count++;
		} else {
			$where .= " AND";
		}
		
		$where .= " remote_host=? ";
		array_push($paramArray, $i);
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

	$rs = $db->Execute("SELECT service, COUNT(service) AS service_count FROM honeypy " . $where . " GROUP BY service ORDER BY service_count DESC;", $paramArray);

	$serviceArray = array();

	foreach($rs as $row) {
		array_push($serviceArray, $row);
	}

	header("Content-type: text/plain");
	echo json_encode($serviceArray);

}
?>
