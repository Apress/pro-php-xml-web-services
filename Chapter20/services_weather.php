<?php
require_once "Services/Weather.php";
$partner_id = '<your partner id>';
$license_key = '<your license key>';

$weather = Services_Weather::service("WeatherDotCom");
$weather->setAccountData($partner_id, $license_key);

/* Get Location */
$location_id = $weather->searchLocation("Portland, Maine");
$locInfo = $weather->getLocation($location_id);
var_dump($locInfo);

/* Get Weather */
$weatherInfo = $weather->getWeather($location_id);
var_dump($weatherInfo);

/* Retrieve Forecast */
$forecastInfo = $weather->getForecast($location_id);
var_dump($forecastInfo);
?>

