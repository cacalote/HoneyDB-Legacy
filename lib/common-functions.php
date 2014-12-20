<?php
function get_days_dropdown($default=10) {
	global $session;

	$html  ='';

	if('view-date' != $_GET['c'] && 'about' != $_GET['c']) {
		if(isset($_REQUEST['days'])) {
			$session->set_sessionvar($_REQUEST['days']);
			$default = $_REQUEST['days'];
		}

		$array = array(
			array('1', '1 Day'),
			array('7', '7 Days'),
			array('10', '10 Days'),
			array('30', '30 Days'),
			array('90', '90 Days'),
			array('183', '6 Months'),
			array('365', '1 Year')
			);

		$html .= '<form action="" id="filter" method="post">';
		$html .= '<select name="days" id="days" onchange="form = document.getElementById(\'filter\'); form.submit();">';
		foreach($array as $r) {
			if($r[0] == $default) { $selected = 'selected'; } else { $selected = ''; }
			$html .= '<option value="' . $r[0] . '" ' . $selected . '>' . $r[1] . '</option>';
		}
		$html .= '</select>';
		$html .= '</form>';
	}
	return $html;
}
?>
