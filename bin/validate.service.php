<?php
$s = !isset($_GET['s']) ? 'all' : trim($_GET['s']);

if(false == filter_var($s, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^[\w-\.]{1,20}$/')))) {
	echo 'service:Error, meh!';
	exit();
}
?>