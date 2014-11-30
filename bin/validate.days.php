<?php
$days = !isset($_GET['days']) ? $DEFAULT_DAYS : trim($_GET['days']);

if(false == filter_var($days, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^[0-9]{1,3}$/')))) {
	echo 'days:Error. Meh!';
	exit();
}
?>
