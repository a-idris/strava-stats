<?php 
	session_start();
	include 'weather.php';
	include 'strava.php';
	//refactor to initalization method
	if (!isset($_SESSION['athlete_id'])) {
		header('location: /stravaweather');
	} else if ($_SESSION['athlete_id'] != $_GET['id']) {
		header('location:/stravaweather/activities.php?id='.$_SESSION['athlete_id']);
	}
	if (isset($_SESSION['token'])) {
		$activities = getStravaItem($_SESSION['token'], "https://www.strava.com/api/v3/athlete/activities");	
	}
	include 'header.php';
?>
<div id="wrapper">
	<div id="strava-data">
		<h2 class="white">All activities:</h2> 
		<ul class="flexlist wrap">
		<?php
			//list 5
			// see all button
			//onclick see graph of wind. mb plotted against speed
			foreach ($activities as $activity) {
				$name = $activity['name'];
				$date = strtotime($activity['start_date_local']);
				$date = date('d/m/y H:i ', $date);
				$avg_speed = $activity['average_speed'];
				$avg_speed = Conversion::msToKmh($avg_speed);
				$distance = $activity['distance'];
				$distance /= 1000;
				//min max wind speeds
				$startTime = strtotime($activity['start_date']);
				// echo var_dump($startTime);
				$weather = getWeather($activity['start_latlng'][0], $activity['start_latlng'][1],$startTime);
				// echo var_dump($weather);
				$wind = $weather['currently']['windSpeed'];
				echo "<li class='item'>"; 
				echo "<p>$name</p>";
				echo "<p>$date</p>";
				echo "<p>${avg_speed}km/h</p>";
				echo "<p>${distance}km</p>";
				echo "<p>wind speed: ${wind}km/h</p>";
				echo "<a href='https://www.strava.com/activities/".$activity['id']."'>See more</a>";
				echo "</li>"; 
			}
		?>
		</ul>
	</div>
</div>	
<?php include 'footer.php' ?>
