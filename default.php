<?php
if(isset($_REQUEST['days'])) {
	$DAYS = intval($_REQUEST['days']);
} else {
	$DAYS = $DEFAULT_DAYS;
}
?>
<div class="container">

<div id="main" style="margin-top:30px" align="center">
	<div id="date-chart" style="height:200px;width:800px;margin-bottom:30px;"></div>
	<table align="center" width="90%">
	<tr>
		<td align="center">Top Attack Hosts<br><small>(last <?php echo $DAYS; ?> days)</small></td>
		<td align="center">Top Attacked Services<br><small>(last <?php echo $DAYS; ?> days)</small></td>
	</tr>
		<td id="top-ip-chart" valign="top" align="center" width="50%"></td>
		<td id="top-service-chart" valign="top" align="center"></td>
	</tr>
	</tr>
		<td id="top-ip-chart-mouseover" valign="top" align="center" width="50%"></td>
		<td id="top-service-chart-mouseover" valign="top" align="center"></td>
	</tr>
	</table>
</div>

<div id="top-ip" style="display:none;"></div>
<div id="top-service" style="display:none;"></div>

</div><!-- /.container -->

<script language="javascript">
$(document).ready(function() {
	// get top list of top ip and top service
	document.getElementById('top-ip').innerHTML      = getTopIp(<?php echo $DAYS; ?>);
	document.getElementById('top-service').innerHTML = getTopService(<?php echo $DAYS; ?>);

	// increase font size of first row
	$('#top-ip-chart-mouseover').css('font-size', '30px');
	$('#top-service-chart-mouseover').css('font-size','30px');

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

	// charting
	s1 = []; // series data
	t1 = []; // tick data
	$.ajax({
			async:    false,
			dataType: 'json',
			url:      'chart-data/bar/days/<?php echo $DAYS; ?>',
			success:  function(data) {
					$.each(data, function() {
							s1.push(this['day_count']);
							t1.push(this['day']);
					});
			}
	});

	// main chart
	var plot1 = $.jqplot('date-chart', [s1], {
		seriesDefaults:{
				renderer:$.jqplot.BarRenderer,
				rendererOptions: {fillToZero: true}
		},	
        axes: {
			// Use a category axis on the x axis and use our custom ticks.
			xaxis: {
				renderer: $.jqplot.CategoryAxisRenderer,
				ticks: t1
				<?php if($DAYS > 10) { ?>
				, tickOptions: {
					show: false,
					showMark: false
				}
				<?php } ?>
			},
			// Pad the y axis just a little so bars can get close to, but
			// not touch, the grid boundaries.  1.2 is the default padding.
			yaxis: {
				pad: 1.05,
				tickOptions: {formatString: '%d'},
				min:0,
				max:<?php echo $CHART_DAILY_Y_MAX; ?>
			}
		},
		grid: {borderColor: 'white', shadow: false, drawBorder: true}
	});
	
	// top ip chart
	var pie_data = [];
	
	$.ajax({
			async:    false,
			dataType: 'json',
			url:      'top-ip/days/<?php echo $DAYS; ?>',
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
		legend: { show:true, location: 'w' },
		grid: {borderColor: 'white', shadow: false, drawBorder: true}
	});
	
	// top service chart
	var pie_data = [];

	$.ajax({
			async:    false,
			dataType: 'json',
			url:      'top-service/days/<?php echo $DAYS; ?>',
			success:  function(data) {
					$.each(data, function() {
							service = [];
							service.push(this['service'].toString());
							service.push(parseInt(this['service_count']));
							pie_data.push(service);
					});
			}
	});

	var plot3 = jQuery.jqplot ('top-service-chart', [pie_data], { 
		seriesDefaults: {
			// Make this a pie chart.
			renderer: jQuery.jqplot.PieRenderer,
			shadow: true,
			rendererOptions: {
			  // Put data labels on the pie slices.
			  // By default, labels show the percentage of the slice.
			  showDataLabels: true,
			  highlightMouseOver: true
			},
			highlighter: {
				show: true,
				showTooltip: true,
				tooltipFade: true,
				formatString: '%s', 
				tooltipLocation: 'sw', 
				useAxesFormatters: false
			}
		}, 
		legend: { show:true, location: 'w' },
		grid: {borderColor: 'white', shadow: false, drawBorder: true}
	});

	// mouseover on charts
	$('#top-ip-chart').bind('jqplotDataHighlight', 
		function (ev, seriesIndex, pointIndex, data) {
			$('#top-ip-chart-mouseover').html($('#top-ip-' + pointIndex).html());
		}
	);

	$('#top-service-chart').bind('jqplotDataHighlight', 
		function (ev, seriesIndex, pointIndex, data) {
			info = data.toString().split(',');
			$('#top-service-chart-mouseover').html(info[0] + '<br><small>(' + info[1] + ')</small>');
		}
	);

	// click on charts
	$('#date-chart').bind('jqplotDataClick', 
		function (ev, seriesIndex, pointIndex, data) {
			url = 'view-date/' + t1[pointIndex] + '/ip';
			location.href = url;
		}
	);

	$('#top-ip-chart').bind('jqplotDataClick', 
		function (ev, seriesIndex, pointIndex, data) {
			url = 'view-ip/' + data[0].replace(/\[/g, '').replace(/\]/g, '');
			location.href = url;
		}
	);

	$('#top-service-chart').bind('jqplotDataClick', 
		function (ev, seriesIndex, pointIndex, data) {
			url = 'view-service/' + data[0].replace(/\[/g, '').replace(/\]/g, '');
			location.href = url;
		}
	);

	$('#top-ip').children('div').click(function(event) {
			ip = $(event.target).text().split(' (');
			url = 'view-ip/' + ip[0];
			location.href = url;
	});

	$('#top-service').children('div').click(function(event) {
			service = $(event.target).text().split(' (');
			url = 'view-service/' + service[0].replace(/\[/g, '').replace(/\]/g, '');
			location.href = url;
	});
});
</script>
