<?php
$d = !isset($_GET['d']) ? $_GET['d'] = 'all' : trim($_GET['d']);
$v = !isset($_GET['v']) ? $_GET['v'] = 'none' : trim($_GET['v']);

if(false == filter_var($d, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^[\w-\. ]{1,10}$/')))) {
        echo 'd:Error, meh!';
        exit();
}

if(false == filter_var($v, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^[\w]{1,7}$/')))) {
        echo 'v:Error, meh!';
        exit();
}

if('all' != $d && 'service' == $_GET['v']) {
	$sql = "SELECT service, COUNT(service) AS service_count FROM honeypy WHERE date=? GROUP BY service ORDER BY service DESC;");

	$rs  = $db->Execute($sql, array($d));

	foreach($rs as $row) {
                array_push($dateArray, $row);
        }

        header("Content-type: text/plain");
        echo json_encode($dateArray);

} elseif('all' != $d) {
	$sql = "SELECT remote_host, COUNT(remote_host) AS ip_count FROM honeypy WHERE date=? $where GROUP BY remote_host ORDER BY remote_host DESC;"

	$rs  = $db->Execute($sql, array($d));

	$dateArray = array();

	foreach($rs as $row) {
		array_push($dateArray, $row);
	}

	header("Content-type: text/plain");
	echo json_encode($dateArray);

} else {
	$where = '';
        if(filter_var($i, FILTER_VALIDATE_IP)) {
                $where = " WHERE remote_host=?";
        }

	$rs = $db->Execute("SELECT date, COUNT(date) AS date_count FROM honeypy $where GROUP BY date ORDER BY date DESC;", array($i));

	$dateArray = array();

	foreach($rs as $row) {
		array_push($dateArray, $row);
	}

	header("Content-type: text/plain");
	echo json_encode($dateArray);

}
?>
