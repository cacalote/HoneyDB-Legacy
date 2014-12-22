<?php
include 'bin/validate.service.php';
include 'bin/validate.view.php';
include 'bin/validate.ip.php';
include 'bin/validate.days.php';

if('all' == $s) {
	$filter_text = '';
	if(isset($_GET['d'])) {
		$filter_text = 'for ' . $_GET['d'];
	}
	
	echo '<div id="view">';
	echo '<table style="width:800px;" align="center"><tr>';
	echo '<td colspan="2"><div style="font-size:18px;">All Services</div></td></tr><tr>';
	echo '<td valign="top" width="50%"><div id="service-all"></div></td>';
	echo '<td valign="top"><div id="top-service-chart"></div><div id="top-service-chart-mouseover" align="center"></div><div id="top-service" style="display:none;"></div></td>';
	echo '</tr></table>';
	echo '</div>';

	// /////// start javascript ///////
	?>
	<script language="javascript">
	document.getElementById('top-service').innerHTML = getTopService(<?php echo $days; ?>);
	document.getElementById("service-all").innerHTML = getServices('<?php echo $WEBROOT; ?>', '<?php echo $i; ?>', '', <?php echo $days;?>);

	$('#service-all').children('div').click(function(event) {
			service = $(event.target).text().split(' (');
			url = '<?php echo $WEBROOT; ?>view-service/' + service[0].replace(/\[/g, '').replace(/\]/g, '');
			location.href = url;
	});

	// top service chart
	var pie_data = [];

	$.ajax({
		async:    false,
		dataType: 'json',
		url:      'top-service/days/<?php echo $days; ?>',
		success:  function(data) {
			$.each(data, function() {
				service = [];
				service.push(this['service'].toString());
				service.push(parseInt(this['service_count']));
				pie_data.push(service);
			});
		}
	});

	var plot2 = jQuery.jqplot ('top-service-chart', [pie_data], {
		title: 'Top 10',
		seriesDefaults: {
			// Make this a pie chart.
			renderer: jQuery.jqplot.PieRenderer,
			shadow: true,
			rendererOptions: {
			  // Put data labels on the pie slices.
			  // By default, labels show the percentage of the slice.
			  showDataLabels: true
			}
		}, 
		legend: { show: true, location: 'w' },
		grid: {borderColor: 'white', shadow: false, drawBorder: true}
	});
	
	$('#top-service-chart').bind('jqplotDataHighlight', 
		function (ev, seriesIndex, pointIndex, data) {
			info = data.toString().split(',');
			$('#top-service-chart-mouseover').html(info[0] + '<br><small>(' + info[1] + ')</small>');
		}
	);
	</script>
	<?php
	// /////// end javascript ///////

} else {
	echo '<div id="view">';
	echo '<div id="view-title">Analysis for ' . $s . '</div>';
	echo '<table width="90%"><tr><td>Hosts</td><td>Events</td><td></td></tr><tr>';
	echo '<td valign="top"><div id="hosts"></div></td>';
	echo '<td valign="top"><div id="events"></div></td>';
	echo '<td valign="top">';
		echo '<div id="tools" style="display:none;">Tools: <button id="php">php</button> <button id="dshield">dshield</button> <button id="firyx">firyx</button> <button id="twitter">twitter</button> <button id="google">google</button> <button id="virustotal">virus total</button></div><br>';
		echo '<div id="ip-info">&nbsp;</div>';
		echo '<div>Request Data</div>';
		echo '<textarea cols="100" rows="7" id="request-data">Select a RX event.</textarea>';
		echo '<br><br>';
		echo 'Project HoneyPot';
		echo '<pre id="projecthoneypot" style="width:100%;"></pre>';
		echo '<br><br>';
		echo 'Shodan';
		echo '<pre id="shodan" style="width:100%;">Select a host.</pre>';
		echo '<br><br>';
	echo '</td>';
	echo '</tr></table>';
	echo '</div>';

// /////// start javascript ///////
?> 
<script language="javascript">
document.getElementById("hosts").innerHTML = getHosts('<?php echo $WEBROOT; ?>', '<?php echo $s; ?>', <?php echo $days; ?>);
document.getElementById("view-title").innerHTML = document.getElementById("view-title").innerHTML + ' ' + getPort('<?php echo $WEBROOT; ?>', '<?php echo $s; ?>');

$('#hosts').children('div').click(function(event) {
	ip = $(event.target).text().split(' (');
	document.getElementById('request-data').innerHTML = 'Select a RX event';
	document.getElementById('ip-info').innerHTML = ip[0];
	document.getElementById('tools').style.display = '';
	document.getElementById('events').innerHTML = getEvents('<?php echo $WEBROOT; ?>', '<?php echo $s; ?>', ip[0]);
	$("#projecthoneypot").load('<?php echo $WEBROOT; ?>projecthoneypot/' + ip[0]);
	$("#shodan").load('<?php echo $WEBROOT; ?>shodan/' + ip[0]);
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
<?php   
// /////// end javascript ///////
}
?>
