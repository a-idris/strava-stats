<?php 
	require_once 'inc/func.php';
	define("clientId","");
	define("clientSecret","");
	$public_token = "";
	$strava_oauth_url = "https://www.strava.com/oauth/authorize?client_id=".clientId."&redirect_uri=http://127.0.0.1/stravaweather/main.php&response_type=code";
	
	function authenticate($code) {
		$strava_token_url =  "https://www.strava.com/oauth/token";
		$parameters = array(
			"client_id" => clientId,
			"client_secret" => clientSecret,
			"code" => $code
		);
		$response = urlPostToArray($strava_token_url, $parameters);
		// $token = $response['access_token'];
		return $response;		
	}

	function getStravaItem($token, $url) {
		$url = $url."?access_token=".$token;
		$item = urlGetToArray($url);
		return $item;
	}
?>