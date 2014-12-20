<?php
$days = !isset($_REQUEST['days']) ? $session->get_sessionvar('days') : trim($_REQUEST['days']);

if(false == filter_var($days, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^[0-9]{1,3}$/')))) {
	echo 'days:Error. Meh!';
	exit();
} else {
	$session->set_sessionvar('days', $days);
}
?>
