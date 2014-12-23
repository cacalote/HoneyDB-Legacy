<?php
include 'bin/validate.date.php';
include 'bin/validate.view.php';
include 'bin/validate.ip.php';
include 'bin/validate.service.php';
include 'bin/validate.days.php';

$title = '';

switch($v) {
	case 'ip':
		$title = 'Analysis for ' . $date . ' by ip: <br><small>view by <a href="' . $WEBROOT . 'view-date/' . $date . '/service">service</a></small>';
		break;
	case 'service':
		$title = 'Analysis for ' . $date . ' by service: <br><small style="font:8px;">view by <a href="' . $WEBROOT . 'view-date/' . $date . '/ip">ip</a></small>';
		break;
	default:
		$title = 'All Dates';
		break;
}

echo '<div id="view">';
echo '<div id="view-title">' . $title . '</div>';
echo '<div id="country"></div>';

switch($v) {
	case 'ip':
		echo '<table width="90%"><tr><td>Hosts</td><td>Events</td><td></td></tr><tr>';
		echo '<td valign="top"><div id="hosts"></div></td>';
		echo '<td valign="top"><div id="events"></div></td>';
		echo '<td valign="top">';
			echo '<div id="tools">Tools: <button id="dshield">dshield</button> <button id="firyx">firyx</button> <button id="twitter">twitter</button> <button id="google">google</button> <button id="virustotal">virus total</button></div><br>';
			echo '<div id="ip-info">&nbsp;</div>';
			echo '<div>Request Data</div>';
			echo '<textarea cols="100" rows="7" id="request-data">Select a RX event.</textarea>';
			echo '<br><br>';
			echo '<pre id="request-data-hex"></pre>';
			echo '<br><br>';
			echo 'Project HoneyPot';
			echo '<pre id="projecthoneypot" style="width:100%;"></pre>';
			echo '<br><br>';
			echo 'Host Ports and  Banners';
			echo '<pre id="shodan" style="width:100%;"></pre>';
			echo '<br><br>';
		echo '</td></tr></table>';
		break;

	case 'service':
		echo '<table width="90%"><tr><td>Services</td><td>Events</td><td></td></tr><tr>';
		echo '<td valign="top"><div id="services"></div></td>';
		echo '<td valign="top"><div id="events"></div></td>';
		echo '<td valign="top">';
			echo '<div id="service-info">&nbsp;</div>';
			echo '<div>Request Data</div>';
			echo '<textarea cols="100" rows="7" id="request-data">Select a RX event.</textarea>';
			echo '<br><br>';
			echo '<pre id="request-data-hex"></pre>';
			echo '<br><br>';
		echo '</td></tr></table>';
		break;

	default:
		echo '<table style="margin-left:25px;"><tr>';
		echo '<td><div id="date-all"></div></td>';
		echo '</tr></table>';
		break;
}

echo '</div>';

// /////// start javascript ///////
echo '<script language="javascript">';
switch($v) {
	case 'ip':
		echo 'document.getElementById("hosts").innerHTML    = getHostsByDate("' . $WEBROOT . '", "' . $date . '");';
		echo '$("#projecthoneypot").load("' . $WEBROOT . 'projecthoneypot/' . $i . '");';
		echo '$("#shodan").load("' . $WEBROOT . '/shodan/' . $i . '");';
		break;

	case 'service':
		echo 'document.getElementById("services").innerHTML = getServicesByDate("' . $WEBROOT . '", "' . $date . '");';
		break;
	
	default:
		echo 'document.getElementById("date-all").innerHTML = getDates("' . $WEBROOT . '", "' . $d . '", "' . $days . '");';
		echo '$("#date-all").children("div").click(function(event) { d = $(event.target).text().split(" ("); url = "' . $WEBROOT . 'view-date/" + d[0] + "/ip"; location.href = url; });';
		break;
}
echo '</script>';
// /////// end javascript ///////
?>
<script language="javascript">
$('#hosts').children('div').click(function(event) {
	ip = $(event.target).text().split(' (');
	document.getElementById('request-data').innerHTML = 'Select a RX event';
	document.getElementById('ip-info').innerHTML = ip[0];
	document.getElementById('tools').style.display = '';
	document.getElementById('events').innerHTML = getEventsByDate('<?php echo $WEBROOT; ?>', '<?php echo $date; ?>', '<?php echo $s; ?>', ip[0]);
	$("#projecthoneypot").load('<?php echo $WEBROOT; ?>projecthoneypot/' + ip[0]);
	$("#shodan").load('<?php echo $WEBROOT; ?>shodan/' + ip[0]);
});

$('#services').children('div').click(function(event) {
	service = $(event.target).text().split(' (');
	document.getElementById('service-info').innerHTML = service[0];
	document.getElementById('events').innerHTML = getEventsByDate('<?php echo $WEBROOT; ?>', '<?php echo $date; ?>', service[0], '<?php echo $i; ?>');
});

$('#dshield').click(function(event) {
        event.preventDefault();
        window.open('https://www.dshield.org/ipinfo.html?ip=' + document.getElementById('ip-info').innerHTML, 'dshield-ip-info', 'width=800,height=600,toolbar=no,scrollbars=yes');
});

$('#firyx').click(function(event) {
        event.preventDefault();
        window.open('https://www.firyx.com/whois?ip=' + document.getElementById('ip-info').innerHTML, 'firyx-ip-info', 'width=800,height=600,toolbar=no,scrollbars=yes');
});

$('#twitter').click(function(event) {
        event.preventDefault();
        window.open('https://twitter.com/search?f=realtime&q=' + document.getElementById('ip-info').innerHTML + '&src=typd', 'twitter-ip-info', 'width=1200,height=600,toolbar=no,scrollbars=yes');
});

$('#google').click(function(event) {
        event.preventDefault();
        window.open('https://www.google.com/#q=' + document.getElementById('ip-info').innerHTML + '&src=typd', 'google-ip-info', 'width=800,height=600,toolbar=no,scrollbars=yes');
});

$('#virustotal').click(function(event) {
        event.preventDefault();
        window.open('https://www.virustotal.com/en/ip-address/' + document.getElementById('ip-info').innerHTML + '/information/', 'virustotal-ip-info', 'width=800,height=600,toolbar=no,scrollbars=yes');
});
</script>
