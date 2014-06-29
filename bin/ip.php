<?php
$i = !isset($_GET['i']) ? $_GET['i'] = 'all' : trim($_GET['i']);
$s = !isset($_GET['s']) ? $_GET['s'] = ' '   : strtolower(trim($_GET['s']));

if(false == filter_var($i, FILTER_VALIDATE_IP) && 'all' != $i) {
	echo 'i:Error, meh!';
	exit();
}

if(false == filter_var($s, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^[\w-\. ]{1,20}$/')))) {
	echo 's:Error, meh!';
	exit();
}

$where      = '';
$paramArray = array();

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
	if(strlen(trim($s))) {
                $where = " WHERE service=?";
		array_push($paramArray, '[' . $s . ']');
        }

        $rs = $db->Execute("SELECT remote_host, COUNT(remote_host) AS ip_count FROM honeypy $where GROUP BY remote_host ORDER BY ip_count DESC;", $paramArray);

        $ipArray = array();

        foreach($rs as $row) {
                array_push($ipArray, $row);
        }

        header("Content-type: text/plain");
        echo json_encode($ipArray);

}
?>
