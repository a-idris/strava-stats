<?php
	session_start();	
	include 'strava.php';
	include 'weather.php';
	if (isset($_SESSION['token'])) {
		$friends = getStravaItem($_SESSION['token'], "https://www.strava.com/api/v3/athlete");

	}
	if (!isset($_SESSION['athlete_id'])) {
		header('location: /stravaweather');
	} else if ($_SESSION['athlete_id'] != $_GET['id']) {
		header('location:/stravaweather/friends.php?id='.$_SESSION['athlete_id']);
	}
	if (isset($_SESSION['token'])) {
		$friends = getStravaItem($_SESSION['token'],  "https://www.strava.com/api/v3/athlete/friends");
	}
	include 'header.php';
?>
<div id="wrapper">
	<div id="strava-data">
		<h2 class="white">All activities:</h2> 
		<ul class="flexlist wrap">
		<?php
			foreach ($friends as $friend) {
				$id = $friend['id'];
				$fname = $friend['firstname'];
				$lname = $friend['lastname'];
				$picUrl = $friend['profile_medium'];
				$fCity = $friend['city'];
				$fCountry = $friend['country'];
				
				echo "<li class='item'>"; 
				echo "<img src='".$picUrl."'>";
				echo "<p>".$fname." ".$lname."</p>";
				if (!empty($fCity)) {
					echo "<p>".$fCity.", ".$fCountry."</p>";
				}
				echo "<a href='https://www.strava.com/athletes/".$id."'>See more</a>";
				echo "</li>"; 
			}
		?>
		</ul>
	</div>
</div>
<?php include 'footer.php' ?>
