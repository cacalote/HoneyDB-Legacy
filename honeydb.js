/* honeydb.js */
function getTopIp() {
        html = '';
        $.ajax({
                async:    false,
                dataType: 'json',
                url:      'top-ip',
                success:  function(data) {
                        var i = 0;
                        $.each(data, function() {
                                i++;
                                html += '<div id="top-ip-' + i + '">' + this['remote_host'] + ' (' + this['ip_count'] + ')</div>';
                        });
                }
        });
        return html;
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

function getHosts(webRoot, service) {
	webRoot = typeof webRoot !== 'undefined' ? webRoot : '/';
	service = typeof service !== 'undefined' ? service : '';

        html = '';
        $.ajax({
                async:    false,
                dataType: 'json',
                url:      webRoot + 'ip/all/' + service,
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

function getServices(webRoot, ip) {
	webRoot = typeof webRoot !== 'undefined' ? webRoot : '/';
	ip      = typeof ip !== 'undefined' ? ip : '';

	html = '';
	$.ajax({
                async:    false,
                dataType: 'json',
                url:      webRoot + 'service/all/' + ip,
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

function getDates(webRoot, date) {
	webRoot = typeof webRoot !== 'undefined' ? webRoot : '/';
        date    = typeof date !== 'undefined' ? date : '';

	html = '';
	$.ajax({
                async:    false,
                dataType: 'json',
                url:      webRoot + 'date/all/' + date,
                success:  function(data) {
                        var i = 0;
                        $.each(data, function() {
                                i++;
                                html += '<div id="date-' + i + '">' + this['date'] + ' (' + this['date_count'] + ')</div>';
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
        ip      = typeof ip !== 'undefined' ? ip : '';

	html = '';

	if(!service.length) { alert('s:Error, meh!'); return html; }
	if(!service.length) { alert('i:Error, meh!'); return html; }

        $.ajax({
                async:    false,
                dataType: 'json',
                url:      webRoot + 'event/service/' + service + '/ip/' + ip,
                success:  function(data) {
                        var i = 0;
                        $.each(data, function() {
                                i++;
                                html += '<div id="event-' + i + '" onclick="loadEventData(\'' + webRoot + '\', \'request-data\', \'' + this['data'] + '\');">' + this['date_time'] + ' '  + this['event'] + '</div>';
                        });
                }
        });
        return html;
}

function loadEventData(webRoot, id, data) {
	webRoot = typeof webRoot !== 'undefined' ? webRoot : '/';
	id      = typeof id !== 'undefined' ? id : '';
        data    = typeof data !== 'undefined' ? data : '';

	if('null' != data) {
		$("#" + id).load(webRoot + 'event-data/' + data);
	}
}

function loadBadHosts() {
	document.getElementById('main').innerHTML = getBadHosts();
}

function getTopService() {
        html = '';
        $.ajax({
                async:    false,
                dataType: 'json',
                url:      'top-service',
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

