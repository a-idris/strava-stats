<?php
// date_default_timezone_set("Asia/Almaty");

//functions

function curl_get($url) {
	$ch = curl_init();
	curl_setopt_array($ch, array(
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_URL => $url,
	));
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}

function curl_post($url, array $kvPairs) {
	$ch = curl_init();
	curl_setopt_array($ch, array(
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_URL => $url,
		CURLOPT_POST => 1,
		CURLOPT_POSTFIELDS => $kvPairs
	));
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}

function urlGetToArray($url) {
	$json = curl_get($url);
	$array = json_decode($json, true);
	return $array;
}

function urlPostToArray($url, array $kvPairs) {
	$json = curl_post($url, $kvPairs);
	$array = json_decode($json, true);
	return $array;
}

function varQuotes($var) {
	return "'".$var."'";
}

//classes

class Conversion {
	//kelvin constant
	const ZERO_KELVIN = -273.15;

	//temperature conversion methods

	public static function kelvinToCelcius($k) {
		return $k + self::ZERO_KELVIN;
	}

	public static function kelvinToFahrenheit($k) {
		return self::celciusToFahrenheit(self::kelvinToCelcius($k));
	}

	public static function celciusToFahrenheit($c) {
		$result = ($c * 1.8) + 32;
		return $result;
	}

	public static function fahrenheitToCelcius($f) {
		$result = ($f - 32) / 1.8;
		return $result;
	}

	//speed conversion methods

	public static function kmhToMph($kmh) {
		return $kmh / 1.609344;
	}

	public static function mphToKmh($mph) {
		return $mph * 1.609344;
	}

	public static function msToKmh($ms) {
		return 3.6 * $ms;
	}

	public static function kmhToMs($kmh) {
		return (1 / 3.6) * $kmh;
	}

	public static function msToMph($ms) {
		return self::kmhToMph(self::msToKmh($ms));
	}

	public static function mphToMs($mph) {
		return self::kmhToMs(self::mphToKmh($mph));
	}

	public static function kmhToKmPace($kmh) {
		return 60.0 / $kmh;
	}

	public static function kmPaceToKmh($kmPace) {
		return 60.0 / $kmhPace;
	}

	public static function mphToMPace($mph) {
		return 60.0 / $mph;
	}

	public static function mPaceToMph($mPace) {
		return 60.0 / $mPace;
	}

	//time conversion methods

}

?>
