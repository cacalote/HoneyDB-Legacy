<?php
$s = !isset($_GET['s']) ? $_GET['s'] = 'service-not-provided' : trim($_GET['s']);

if(false == filter_var($_GET['s'], FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^[a-zA-Z-\.]{1,25}$/')))) {
        echo 's:Error. Meh!';
        exit();
}

$where = " WHERE service=? ";

$rs = $db->Execute("SELECT local_port FROM honeypy $where LIMIT 1;", array('[' . $s . ']'));

$serviceArray = array();

foreach($rs as $row) {
	array_push($serviceArray, $row);
}

header("Content-type: text/plain");
echo json_encode($serviceArray);

?>
