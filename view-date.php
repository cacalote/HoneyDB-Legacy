<?php
$d = !isset($_GET['d']) ? $_GET['d'] = 'all' : trim($_GET['d']);

if(false == filter_var($d, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^[\w-\. ]{1,10}$/')))) {
        echo 'd:Error, meh!';
        exit();
}

if('all' == $d) {
	echo '<div id="view">';
	echo '<div style="font-size:18px;">All Dates</div>';
	echo '<table style="margin-left:25px;"><tr>';
	echo '<td><div id="date-all"></div></td>';
	echo '</tr></table>';
	echo '</div>';

// /////// start javascript ///////
?>
<script language="javascript">
document.getElementById("date-all").innerHTML = getDates('<?php echo $WEBROOT; ?>');

$('#date-all').children('div').click(function(event) {
        d   = $(event.target).text().split(' (');
        url = '<?php echo $WEBROOT; ?>view-date/' + d[0];
        location.href = url;
});
</script>
<?php
// /////// end javascript ///////

} else {
	echo '<div id="view">';
	echo '<div id="view-title">Analysis for ' . $d . '</div>';
	echo '<div id="country"></div>';
	echo '<table width="90%"><tr><td>Services</td><td>Events</td><td></td></tr><tr>';
	echo '<td valign="top"><div id="dates"></div></td>';
	echo '<td valign="top"><div id="events"></div></td>';
	echo '<td valign="top">';
		echo '<div id="tools">Tools: <button id="php">php</button> <button id="dshield">dshield</button> <button id="firyx">firyx</button></div><br>';
		echo '<div id="date-info">&nbsp;</div>';
		echo '<div>Request Data</div>';
		echo '<textarea cols="100" rows="7" id="request-data">Select a RX event.</textarea>';
		echo '<br><br>';
		echo 'Host Ports and  Banners';
		//echo '<textarea cols="100" rows="7" id="shodan"></textarea>';
		echo '<pre id="shodan" style="width:100%;"></pre>';
		echo '<br><br>';
	echo '</td>';
	echo '</tr></table>';
	echo '</div>';

// /////// start javascript ///////
?>
<script language="javascript">
$.ajax({
	async:    false,
	dataType: 'json',
	url:      '<?php echo $WEBROOT; ?>geoip/<?php echo $i; ?>',
	success:  function(data) {
		$('#country').append('<img src="http://foospidy.com/opt/honeydb/img/flags/' + data['countryIsoCode'].toLowerCase() + '.png"> ' + data['countryName']);
	}
});

document.getElementById("dates").innerHTML = getServices('<?php echo $WEBROOT; ?>', '<?php echo $i; ?>');

$('#dates').children('div').click(function(event) {
        date = $(event.target).text().split(' (');
	document.getElementById('date-info').innerHTML = date[0];
	document.getElementById('events').innerHTML = getEvents('<?php echo $WEBROOT; ?>', date[0], '<?php echo $i; ?>');
});

$("#shodan").load('<?php echo $WEBROOT; ?>shodan/<?php echo $i; ?>');

/*
$('#whois').click(function(event) {
	event.preventDefault();
	window.open('https://who.is/whois-ip/ip-address/<?php echo $i; ?>', 'whois', 'width=800,height=600,toolbar=no,scrollbars=yes');
});
*/

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
</script>
<?php   
// /////// end javascript ///////
}
?>
