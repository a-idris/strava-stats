<?php 
	include 'strava.php';
?>
<!DOCTYPE html> 
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/main.css">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
		<script type="text/javascript" src="js/script.js"></script>
		<title>Strava Weather</title>
	</head>
	<body>
		<img src="img/cover.png" id="coverPic">
		<div id="login-btn">
			<!-- refactor to button get -->
			<a href=<?php echo '"'.$strava_oauth_url.'"' ?>><img src="img/ConnectWithStrava.png"></a>
		</div>
	</body>
</html>
