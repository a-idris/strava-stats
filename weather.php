<?php
	require_once 'inc/func.php';
	define("apiKey","");
	define("endpoint","https://api.forecast.io/forecast/".apiKey."/");

	if (!isset($_POST['location'])) {
		//use ipinfo.io to get default long/lat.
		//UNCOMMENT IF TRANSFERRING FROM LOCALHOST
		// $iplocation = urlGetToArray("http://ipinfo.io/".$_SERVER['REMOTE_ADDR']."/json"); 
		//check cookies.
		// if (!getCookie()) {
			$iplocation = urlGetToArray("http://ipinfo.io/json"); 
			$city = $iplocation['city'];
			$country = $iplocation['country'];
			$locExploded = explode(",",$iplocation['loc']);
			$lat = $locExploded[0];
			$long = $locExploded[1];
		// }
	} else {
		$post_location = urlencode($_POST['location']);
		$url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$post_location;
		$location = urlGetToArray($url);
		$city = $location['results'][0]['address_components'][0]['long_name'];	
		$country_array_index = count($location['results'][0]['address_components']) - 1; 
		$country = $location['results'][0]['address_components'][$country_array_index]['long_name'];	
		$lat = $location['results'][0]['geometry']['location']['lat'];
		$long = $location['results'][0]['geometry']['location']['lng'];
		//use session lat. session long. mb unset post vars to stop from "confirm form resubmission"
		if ((isset($_POST['to_default'])) && ($_POST['to_default'] == 'checked')) {
			//cookie logic
			echo "ayy";
			// $_SESSION['athlete_id']
		}
	}

	function getWeather($lat, $long, $time = null) {
		if ($time == null) {
			$url = endpoint.$lat.",".$long."?units=ca";
		} else {
			$url = endpoint.$lat.",".$long.",".$time."?units=ca";
		}
		$result = urlGetToArray($url);
		return $result;
	}
?>
