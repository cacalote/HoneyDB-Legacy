<?php
use GeoIp2\Database\Reader;

$a = !isset($_GET['a']) ? $_GET['a'] = 'all' : trim($_GET['a']);

$reader = new Reader('usr/data/GeoLite2-City.mmdb');

// perform validation
if(false == filter_var($_GET['i'], FILTER_VALIDATE_IP)) {
        echo 'i:Error, meh!';
        exit();
}

switch($a) {
	default:
		$record     = $reader->city($_GET['i']);
		$geoIpArray = array(
				'countryIsoCode'     => $record->country->isoCode,
				'countryName'        => $record->country->name,
				'subdivisionIsoCode' => $record->mostSpecificSubdivision->isoCode,
				'subdivisionName'    => $record->mostSpecificSubdivision->name,
				'cityName'           => $record->city->name,
				'postalCode'         => $record->postal->code,
				'latitude'           => $record->location->latitude,
				'longitude'          => $record->location->longitude
				);

		header("Content-type: text/plain");
		echo json_encode($geoIpArray);
		break;
}
?>
