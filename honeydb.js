/* honeydb.js */
function getTopIp(days) {
	days       = typeof days !== 'undefined' ? days : 0;
	html       = '';
	append_url = '';

	if(days>0) {
		append_url = '/days/' + days;
	}

	$.ajax({
		async:    false,
		dataType: 'json',
		url:      'top-ip' + append_url,
		success:  function(data) {
				var i = 0;
				$.each(data, function() {
						html += '<div id="top-ip-' + i + '">' + this['remote_host'] + ' (' + this['ip_count'] + ')</div>';
						i++;
				});
		}
	});
	return html;
}

function getTopService(days) {
	days = typeof days !== 'undefined' ? days : 0;
	html = '';
	append_url = '';

	if(days>0) {
		append_url = '/days/' + days;
	}

	$.ajax({
		async:    false,
		dataType: 'json',
		url:      'top-service' + append_url,
		success:  function(data) {
			var i = 0;
			$.each(data, function() {
				i++;
				html += '<div id="top-service-' + i + '">' + this['service'] + ' (' + this['service_count'] + ')</div>';
			});
		}
	});
	return html;
}

function getHosts(webRoot, service, days, date) {
	webRoot    = typeof webRoot !== 'undefined' ? webRoot : '/';
	service    = typeof service !== 'undefined' ? service : '';
	days       = typeof days    !== 'undefined' ? days    : 0;
	date       = typeof date    !== 'undefined' ? '/date/' + date   : '';
	html       = '';
	append_url = '';

	if(days > 0) {
		if(service.length) {
			append_url += '/';
		}
		append_url += 'days/' + days;
	}

	$.ajax({
		async:    false,
		dataType: 'json',
		url:      webRoot + 'ip/all/' + service + append_url,
		success:  function(data) {
			var i = 0;
			$.each(data, function() {
				i++;
				html += '<div id="ip-' + i + '">' + this['remote_host'] + ' (' + this['ip_count'] + ')</div>';
			});
		}
	});
	return html;
}

function getHostsByDate(webRoot, date) {
	webRoot = typeof webRoot !== 'undefined' ? webRoot : '/';
	date    = typeof date    !== 'undefined' ? date    : 'all';
	html    = '';
   
	$.ajax({
		async:    false,
		dataType: 'json',
		url:      webRoot + 'ip/all/date/' + date,
		success:  function(data) {
			var i = 0;
			$.each(data, function() {
				i++;
				html += '<div id="ip-' + i + '">' + this['remote_host'] + ' (' + this['ip_count'] + ')</div>';
			});
		}
	});
	return html;
}

function getServices(webRoot, ip, date, days) {
	webRoot    = typeof webRoot !== 'undefined' ? webRoot : '/';
	ip         = typeof ip      !== 'undefined' ? ip      : 'all';
	date       = typeof date    !== 'undefined' ? date    : '';
	days       = typeof days    !== 'undefined' ? days    : 0;
	html       = '';
	append_url = '';
	
	append_url += 'all/' + ip;
	
	if(days > 0) {
		append_url += '/days/' + days;
	}

	$.ajax({
		async:    false,
		dataType: 'json',
		url:      webRoot + 'service/' + append_url,
		success:  function(data) {
			var i = 0;
			$.each(data, function() {
					i++;
					html += '<div id="service-' + i + '">' + this['service'] + ' (' + this['service_count'] + ')</div>';
			});
		}
	});
	return html;
}

function getServicesByDate(webRoot, date) {
	webRoot = typeof webRoot !== 'undefined' ? webRoot : '/';
	date    = typeof date    !== 'undefined' ? date    : 'all';
	html    = '';
	
	$.ajax({
		async:    false,
		dataType: 'json',
		url:      webRoot + 'service/all/date/' + date,
		success:  function(data) {
			var i = 0;
			$.each(data, function() {
					i++;
					html += '<div id="service-' + i + '">' + this['service'] + ' (' + this['service_count'] + ')</div>';
			});
		}
	});
	return html;
}

function getDates(webRoot, date, days) {
	webRoot = typeof webRoot !== 'undefined'  ? webRoot : '/';
	date    = typeof date    !== 'undefined'  ? date    : '';
	days    = typeof days    !== 'undefined'  ? days    : 0;
	date    = date           !== '0000-00-00' ? date    : '';
	html    = '';

	if(date.length) {
		append_url = date;
	} else {
		append_url = 'all';
	}
	
	append_url += '/days/' + days;

	$.ajax({
		async:    false,
		dataType: 'json',
		url:      webRoot + 'date/' + append_url,
		success:  function(data) {
			var i = 0;
			$.each(data, function() {
				html += '<div id="date-' + i + '">' + this['date'] + ' (' + this['date_count'] + ')</div>';
				i++;
			});
		}
	});
	return html;
}

function getPort(webRoot, service) {
	webRoot = typeof webRoot !== 'undefined' ? webRoot : '/';
        service = typeof service !== 'undefined' ? service.replace(/\[/g, '').replace(/\]/g, '') : '';

	html = '';

	$.ajax({
                async:    false,
                dataType: 'json',
                url:      webRoot + 'service-port/' + service,
                success:  function(data) {
                        var i = 0;
                        $.each(data, function() {
                                i++;
                                html += '<small>(port ' + this['local_port'] + ')</small>';
                        });
                }
        });

	return html;
}

function getEvents(webRoot, service, ip) {
	webRoot = typeof webRoot !== 'undefined' ? webRoot : '/';
	service = typeof service !== 'undefined' ? service.replace(/\[/g, '').replace(/\]/g, '') : '';
	ip      = typeof ip      !== 'undefined' ? ip : '';

	html = '';

	if(!service.length) { alert('s:Error, meh!'); return html; }
	if(!ip.length) { alert('i:Error, meh!'); return html; }

	$.ajax({
			async:    false,
			dataType: 'json',
			url:      webRoot + 'event/service/' + service + '/ip/' + ip,
			success:  function(data) {
					var i = 0;
					$.each(data, function() {
							i++;
							bytes = null !== this['bytes'] ? this['bytes'] : '';
							html += '<div id="event-' + i + '" onclick="loadEventData(\'' + webRoot + '\', \'request-data\', \'' + this['data'] + '\');">' + this['date_time'] + ' '  + this['event'] + ' '  + bytes + '</div>';
					});
			}
	});
	return html;
}

function loadEventData(webRoot, id, data) {
	webRoot = typeof webRoot !== 'undefined' ? webRoot : '/';
	id      = typeof id      !== 'undefined' ? id : '';
	data    = typeof data    !== 'undefined' ? data : 'null';

	if('null' != data) {
		$("#" + id).load(webRoot + 'event-data/' + data);
		new Hexdump(hex2a(data), {
			container: id + '-hex'
			, base: 'hex'
			, width: 10
			, ascii: true
			, byteGrouping: 0
			, html: false
			, lineNumber: true
			, style: {
				lineNumberLeft: ''
				, lineNumberRight: ':'
				, stringLeft: '|'
				, stringRight: '|'
				, hexLeft: ''
				, hexRight: ''
				, hexNull: '.g'
				, stringNull: '.'
			}
		});
	}
}

// http://stackoverflow.com/questions/3745666/how-to-convert-from-hex-to-ascii-in-javascript
function hex2a(hexx) {
	var hex = hexx.toString();//force conversion
	var str = '';
	for (var i = 0; i < hex.length; i += 2)
		str += String.fromCharCode(parseInt(hex.substr(i, 2), 16));
	return str;
}

function getBadHosts() {
	html = '';
	$.ajax({
			async:    false,
			dataType: 'json',
			url:      'bad-hosts',
			success:  function(data) {
					var i = 0;
					$.each(data, function() {
							i++;
							html += '<div id="bad-ip-' + i + '">' + this['remote_host'] + ' (' + this['ip_count'] + ')</div>';
					});
			}
	});
	return html;
}

function loadBadHosts() {
	document.getElementById('main').innerHTML = getBadHosts();
}
