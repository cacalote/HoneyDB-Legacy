<?php
include 'bin/validate.ip.php';
include 'bin/validate.days.php';

if('all' == $i) {
	echo '<div id="view">';
	echo '<table style="width:800px;" align="center"><tr>';
	echo '<td colspan="2"><div style="font-size:18px;">All Hosts</div></td></tr><tr>';
	echo '<td valign="top" width="50%"><div id="ip-all"></div></td>';
	echo '<td valign="top"><div id="top-ip-chart"></div><div id="top-ip-chart-mouseover" align="center"></div><div id="top-ip" style="display:none;"></div></td>';
	echo '</tr></table>';
	echo '</div>';

	// /////// start javascript ///////
	?>
	<script language="javascript">
	document.getElementById('top-ip').innerHTML = getTopIp(<?php echo $days; ?>);
	document.getElementById("ip-all").innerHTML = getHosts('<?php echo $WEBROOT; ?>', '', <?php echo $days; ?>);

	$('#ip-all').children('div').click(function(event) {
			ip = $(event.target).text().split(' (');
			url = '<?php echo $WEBROOT; ?>view-ip/' + ip[0];
			location.href = url;
	});
	
	// get flag/country for each ip
	i = 0;
	$('#top-ip').children('div').each(function(i) {
		ip = $(this).text().split('(');
		$.ajax({
			async:    false,
			dataType: 'json',
			url:      'geoip/' + ip[0],
			success:  function(data) {
				html = '<div style="font-size:small;"><img src="<?php echo $WEBROOT; ?>img/flags/' + data['countryIsoCode'].toLowerCase() + '.png"> ' + data['countryName'] + '</div>';
				$('#top-ip-' + i).append(html);
			}
		});
		i++;
	});


	// top ip chart
	var pie_data = [];

	$.ajax({
		async:    false,
		dataType: 'json',
		url:      'top-ip/days/<?php echo $days; ?>',
		success:  function(data) {
			$.each(data, function() {
				ip = [];
				ip.push(this['remote_host'].toString());
				ip.push(parseInt(this['ip_count']));
				pie_data.push(ip);
			});
		}
	});

	var plot2 = jQuery.jqplot ('top-ip-chart', [pie_data], {
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
	
	$('#top-ip-chart').bind('jqplotDataHighlight', 
		function (ev, seriesIndex, pointIndex, data) {
			$('#top-ip-chart-mouseover').html($('#top-ip-' + pointIndex).html());
		}
	);

	// uncomment this section to display flag/country for each IP. This will cause the page to take a while to complete loading
	/*
	$('#ip-all').children('div').each(function(i) {
			i++;
			ip = $(this).text().split('(');
			$.ajax({
					async:    false,
					dataType: 'json',
					url:      '<?php echo $WEBROOT; ?>geoip/' + ip[0],
					success:  function(data) {
							html = '<div style="font-size:small;"><img src="<?php echo $WEBROOT; ?>img/flags/' + data['countryIsoCode'].toLowerCase() + '.png"> ' + data['countryName'] + '</div>';
							$('#ip-' + i).append(html);
					}
			});
	});
	*/
	</script>
	<?php
	// /////// end javascript ///////

} else {
	echo '<div id="view">';
	echo '<div id="view-title">Analysis for ' . $i . '</div>';
	echo '<div id="country"></div>';
	echo '<table width="90%"><tr><td>Services</td><td>Events</td><td></td></tr><tr>';
	echo '<td valign="top"><div id="services"></div></td>';
	echo '<td valign="top"><div id="events"></div></td>';
	echo '<td valign="top">';
		echo '<div id="tools">Tools: <button id="dshield">dshield</button> <button id="firyx">firyx</button> <button id="twitter">twitter</button> <button id="google">google</button> <button id="virustotal">virus total</button></div><br>';
		echo '<div id="service-info">&nbsp;</div>';
		echo '<div>Request Data</div>';
		echo '<textarea cols="100" rows="7" id="request-data">Select a RX event.</textarea>';
		echo '<br><br>';
		echo '<pre id="request-data-hex"></pre>';
		echo '<br><br>';
		echo 'Project HoneyPot';
		echo '<pre id="projecthoneypot" style="width:100%;"></pre>';
		echo '<br><br>';
		echo 'Shodan';
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
		$('#country').append('<img src="<?php echo $WEBROOT; ?>img/flags/' + data['countryIsoCode'].toLowerCase() + '.png"> ' + data['countryName']);
	}
});

document.getElementById("services").innerHTML = getServices('<?php echo $WEBROOT; ?>', '<?php echo $i; ?>');

$('#services').children('div').click(function(event) {
        service = $(event.target).text().split(' (');
	document.getElementById('service-info').innerHTML = service[0];
	document.getElementById('events').innerHTML = getEvents('<?php echo $WEBROOT; ?>', service[0], '<?php echo $i; ?>');
});

$("#projecthoneypot").load('<?php echo $WEBROOT; ?>projecthoneypot/<?php echo $i; ?>');
$("#shodan").load('<?php echo $WEBROOT; ?>shodan/<?php echo $i; ?>');


$('#dshield').click(function(event) {
        event.preventDefault();
        window.open('https://www.dshield.org/ipinfo.html?ip=<?php echo $i; ?>', 'dshield-ip-info', 'width=800,height=600,toolbar=no,scrollbars=yes');
});

$('#firyx').click(function(event) {
        event.preventDefault();
        window.open('https://www.firyx.com/whois?ip=<?php echo $i; ?>', 'firyx-ip-info', 'width=800,height=600,toolbar=no,scrollbars=yes');
});

$('#twitter').click(function(event) {
        event.preventDefault();
        window.open('https://twitter.com/search?f=realtime&q=<?php echo $i; ?>&src=typd', 'twitter-ip-info', 'width=1200,height=600,toolbar=no,scrollbars=yes');
});

$('#google').click(function(event) {
        event.preventDefault();
        window.open('https://www.google.com/#q=<?php echo $i; ?>&src=typd', 'google-ip-info', 'width=800,height=600,toolbar=no,scrollbars=yes');
});

$('#virustotal').click(function(event) {
        event.preventDefault();
        window.open('https://www.virustotal.com/en/ip-address/<?php echo $i; ?>/information/', 'virustotal-ip-info', 'width=800,height=600,toolbar=no,scrollbars=yes');
});
</script>
<?php   
// /////// end javascript ///////
}
?>
