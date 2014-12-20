<?php
require 'vendor/autoload.php';
include 'etc/configuration.php';
include 'lib/session.php';
include 'lib/common-functions.php';
include 'bin/validate.c.php';

/// database conn ///
$db = NewADOConnection('mysql');
$db->Connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

/// session ///
$session = new session();

if(!$session->isset_sessionvar('days')) {
	$session->set_sessionvar('days', $DEFAULT_DAYS);
}

switch($_GET['c']) {
	case 'logger':
		include('bin/logger.php');
		break;

	case 'geoip':
		include('bin/geoip.php');
		break;

	case 'whois-data':
		include('bin/whois-data.php');
		break;

	case 'top-ip':
		include('bin/top-ip.php');
		break;

	case 'top-service':
		include('bin/top-service.php');
		break;

	case 'shodan':
		include('bin/shodan.php');
		break;

	case 'projecthoneypot':
		include('bin/projecthoneypot.php');
		break;

	case 'ip':
		include('bin/ip.php');
		break;

	case 'service':
		include('bin/service.php');
		break;

	case 'date':
		include('bin/date.php');
		break;

	case 'service-port':
		include('bin/service-port.php');
		break;

	case 'event':
		include('bin/event.php');
		break;

	case 'event-data':
		include('bin/event-data.php');
		break;

	case 'bad-hosts':
		include('bin/bad-hosts.php');
		break;

	case 'chart-data':
		include('bin/chart-data.php');
		break;

	case 'view-ip':
		include('header.php');
		include('view-ip.php');
		include('footer.php');
		break;

	case 'view-service':
		include('header.php');
		include('view-service.php');
		include('footer.php');
		break;

	case 'view-date':
		include('header.php');
		include('view-date.php');
		include('footer.php');
		break;

	case 'about':
		include('header.php');
		include('about.php');
		include('footer.php');
		break;

	default:
		include('header.php');
		include('default.php');
		include('footer.php');
		break;
}
?>
