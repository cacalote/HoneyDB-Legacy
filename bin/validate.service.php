<?php
$s = !isset($_GET['s']) ? $_GET['s'] = 'all' : trim($_GET['s']);

if(false == filter_var($s, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^[\w-\.]{1,10}$/')))) {
	echo 'service:Error, meh!';
	exit();
}
?>
