<?php
$i = !isset($_GET['i']) ? 'all' : trim($_GET['i']);

if('all' != $i) {
	if(false == filter_var($i, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^[\d\.]{1,15}$/')))) {
		echo 'ip:Error, meh!';
		exit();
	}
}
?>
