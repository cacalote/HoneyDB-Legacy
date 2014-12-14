<?php
$date = !isset($_GET['date']) ? 'all' : trim($_GET['date']);

if('all' != $date) {
	if(false == filter_var($date, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^[\d-]{1,10}$/')))) {
		echo 'date:Error, meh!';
		exit();
	}
}
?>
