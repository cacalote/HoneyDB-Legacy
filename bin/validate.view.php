<?php
$v = !isset($_GET['v']) ? 'none' : trim($_GET['v']);

if(false == filter_var($v, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^(none|ip|service)$/')))) {
	echo 'view:Error, meh!';
	exit();
}
?>
