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
			echo '<div id="tools">Tools: <button id="php">php</button> <button id="dshield">dshield</button> <button id="firyx">firyx</button></div><br>';
			echo '<div id="ip-info">&nbsp;</div>';
			echo '<div>Request Data</div>';
			echo '<textarea cols="100" rows="7" id="request-data">Select a RX event.</textarea>';
			echo '<br><br>';
			echo '<pre id="request-data-hex"></pre>';
			echo '<br><br>';
			//echo 'Host Ports and  Banners';
			//echo '<textarea cols="100" rows="7" id="shodan"></textarea>';
			echo '<pre id="shodan" style="width:100%;"></pre>';
			echo '<br><br>';
		echo '</td></tr></table>';
		break;

	case 'service':
		echo '<table width="90%"><tr><td>Services</td><td>Events</td><td></td></tr><tr>';
		echo '<td valign="top"><div id="services"></div></td>';
		echo '<td valign="top"><div id="events"></div></td>';
		echo '<td valign="top">';
			echo '<div id="tools">Tools: <button id="php">php</button> <button id="dshield">dshield</button> <button id="firyx">firyx</button></div><br>';
			echo '<div id="service-info">&nbsp;</div>';
			echo '<div>Request Data</div>';
			echo '<textarea cols="100" rows="7" id="request-data">Select a RX event.</textarea>';
			echo '<br><br>';
			echo '<pre id="request-data-hex"></pre>';
			echo '<br><br>';
			//echo 'Host Ports and  Banners';
			//echo '<textarea cols="100" rows="7" id="shodan"></textarea>';
			echo '<pre id="shodan" style="width:100%;"></pre>';
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
	document.getElementById('events').innerHTML = getEvents('<?php echo $WEBROOT; ?>', '<?php echo $s; ?>', ip[0]);
	$("#projecthoneypot").load('<?php echo $WEBROOT; ?>projecthoneypot/' + ip[0]);
	$("#shodan").load('<?php echo $WEBROOT; ?>shodan/' + ip[0]);
});

$('#services').children('div').click(function(event) {
	service = $(event.target).text().split(' (');
	document.getElementById('service-info').innerHTML = service[0];
	document.getElementById('events').innerHTML = getEvents('<?php echo $WEBROOT; ?>', service[0], '<?php echo $i; ?>');
});

/*
$.ajax({
	async:    false,
	dataType: 'json',
	url:      '<?php echo $WEBROOT; ?>geoip/<?php echo $i; ?>',
	success:  function(data) {
		$('#country').append('<img src="https://foospidy.com/opt/honeydb/img/flags/' + data['countryIsoCode'].toLowerCase() + '.png"> ' + data['countryName']);
	}
});

document.getElementById("dates").innerHTML = getServices('<?php echo $WEBROOT; ?>', '<?php echo $i; ?>');



$("#shodan").load('<?php echo $WEBROOT; ?>shodan/<?php echo $i; ?>');

$('#php').click(function(event) {
        event.preventDefault();
        window.open('https://www.projecthoneypot.org/ip_<?php echo $i; ?>', 'php', 'width=800,height=600,toolbar=no,scrollbars=yes');
});

$('#dshield').click(function(event) {
        event.preventDefault();
        window.open('https://www.dshield.org/ipinfo.html?ip=<?php echo $i; ?>', 'dshield-ip-info', 'width=800,height=600,toolbar=no,scrollbars=yes');
});

https://www.firyx.com/whois?ip=91.109.20.135
$('#firyx').click(function(event) {
        event.preventDefault();
        window.open('https://www.firyx.com/whois?ip=<?php echo $i; ?>', 'firyx-ip-info', 'width=800,height=600,toolbar=no,scrollbars=yes');
});
*/
</script>
