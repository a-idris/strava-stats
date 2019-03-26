<!DOCTYPE html> 
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/main.css">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
		<script type="text/javascript" src="js/script.js"></script>
		<title>Strava Weather</title>
	</head>
	<body>
		<nav>
			<div id="logo" class="white"><h1><a href="main.php">S T R A V A W E A T H E R</h1></div>
			<a href=<?php echo "'main.php?id=".$_SESSION['athlete_id']."'" ?>>Home</a> 
			<a href=<?php echo "'activities.php?id=".$_SESSION['athlete_id']."'" ?>>Activities</a> 
			<a href=<?php echo "'friends.php?id=".$_SESSION['athlete_id']."'" ?>>Friends</a> 
			<a href="logout.php">Log out</a> 
		</nav>