<?php
$d = !isset($_GET['d']) ? '0000-00-00' : trim($_GET['d']);

if(false == filter_var($d, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^[\d-]{1,10}$/')))) {
	echo 'date:Error, meh!';
	exit();
}
?>