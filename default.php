<div class="container">

<div id="main" style="margin-top:30px" align="center">
	<div id="chartdiv" style="height:200px;width:800px;margin-bottom:30px;"></div>
	<table align="center" width="90%">
	<tr>
		<td align="center">Top Offending Hosts</td><td align="center">Top Attacked Services</td>
	</tr>
		<td id="top-ip" valign="top" align="center" width="50%"></td>
		<td id="top-service" valign="top" align="center"></td>
	</tr>
	</table>
</div>

</div><!-- /.container -->

<script language="javascript">
$(document).ready(function() {


document.getElementById('top-ip').innerHTML      = getTopIp();
document.getElementById('top-service').innerHTML = getTopService();

$('#top-ip-1').css('font-size', '30px');
$('#top-service-1').css('font-size','30px');

/*
i = 0;
$('#top-ip').children('div').each(function(i) {
        i++;
        ip = $(this).text().split('(');
        $.ajax({
                async:    false,
                dataType: 'json',
                url:      'geoip/' + ip[0],
                success:  function(data) {
                        html = '<div style="font-size:small;"><img src="http://foospidy.com/opt/honeydb/img_flags/' + data['countryIsoCode'].toLowerCase() + '.png"> ' + data['countryName'] + '</div>';
                        $('#top-ip-' + i).append(html);
                }
        });
});
*/

// charting
s1 = []; // series data
t1 = []; // tick data
$.ajax({
        async:    false,
        dataType: 'json',
        url:      'chart-data/bar',
        success:  function(data) {
                $.each(data, function() {
                        s1.push(this['day_count']);
                        t1.push(this['day']);
                });
        }
});

console.log(s1);
var plot1 = $.jqplot('chartdiv', [s1], {
        seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                rendererOptions: {fillToZero: true}
        },
        axes: {
            // Use a category axis on the x axis and use our custom ticks.
            xaxis: {
                renderer: $.jqplot.CategoryAxisRenderer,
                ticks: t1
/*
		tickOptions: {
			show:false
		},
		rendererOptions: {
			drawBaseline:false
		}
*/
            },
            // Pad the y axis just a little so bars can get close to, but
            // not touch, the grid boundaries.  1.2 is the default padding.
            yaxis: {
                pad: 1.05,
                tickOptions: {formatString: '%d'},
		min:0,
		max:1000
            }
        }
});

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

