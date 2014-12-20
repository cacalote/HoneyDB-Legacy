<?php
if(!isset($_GET['c'])) { $_GET['c'] = 'default'; }

// perform validation
if(false == filter_var($_GET['c'], FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^[a-z-]{1,15}$/')))) {
	echo 'c:Error. Meh!';
	exit();
}
?>
