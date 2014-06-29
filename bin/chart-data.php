<?php

switch($_GET['a']) {
	case 'bar':
		$sql  = "SELECT DATE_FORMAT(date_time, '%Y-%m-%d') AS day, COUNT(*) AS day_count FROM honeypy l ";
		$sql .= "GROUP BY DATE_FORMAT(date_time, '%Y-%m-%d') ORDER BY date_time DESC LIMIT 10;";
		$rs   = $db->Execute($sql);

		$dataArray = array();

		foreach($rs as $row) {
			array_push($dataArray, $row);
		}
		header("Content-type: text/plain");
		echo json_encode($dataArray);
		break;
}
?>
