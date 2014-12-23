<?php
use GeoIp2\Database\Reader;
include 'validate.ip.php';

$reader = new Reader('usr/data/GeoLite2-City.mmdb');

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
?>
