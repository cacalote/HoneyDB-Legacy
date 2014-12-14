<?php
if(isset($_REQUEST['days'])) {
	// validate
	$days = intval($_REQUEST['days']);
} else {
	$days = $DEFAULT_DAYS;
}

switch($_GET['a']) {
	case 'bar':
		$params = array($days);
		$sql    = "SELECT DATE_FORMAT(date_time, '%Y-%m-%d') AS day, COUNT(*) AS day_count FROM honeypy WHERE event='CONNECT' ";
		$sql   .= "GROUP BY DATE_FORMAT(date_time, '%Y-%m-%d') ORDER BY date_time DESC LIMIT ?;";
		$rs     = $db->Execute($sql, $params);

		$dataArray = array();

		foreach($rs as $row) {
			array_push($dataArray, $row);
		}
		header("Content-type: text/plain");
		echo json_encode($dataArray);
		break;
}
?>
