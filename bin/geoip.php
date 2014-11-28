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
		try {
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
		} catch (Exception $e) {
			// error reading data or ip not found in db
			$geoIpArray = array(
				'countryIsoCode'     => 'unknown',
				'countryName'        => 'unknown',
				'subdivisionIsoCode' => 'unknown',
				'subdivisionName'    => 'unknown',
				'cityName'           => 'unknown',
				'postalCode'         => 'unknown',
				'latitude'           => 'unknown',
				'longitude'          => 'unknown'
				);
		}

		header("Content-type: text/plain");
		echo json_encode($geoIpArray);
		break;
}
?>
