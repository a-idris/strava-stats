<?php 
	session_start();
	include 'weather.php';
	include 'strava.php';
	//refactor to initalization method
	if (isset($_GET['code'])) {
		//initializon of session vars when first logging in.
		$code = $_GET['code'];
		$response = authenticate($code);
		$_SESSION['token'] = $response['access_token'];
		$_SESSION['athlete_id'] = $response['athlete']['id'];		
		header('location: /stravaweather/main.php?id='.$_SESSION['athlete_id']);
	} 
	if (!isset($_SESSION['athlete_id'])) {
		header('location: /stravaweather');
	} else if ($_SESSION['athlete_id'] != $_GET['id']) {
		header('location:/stravaweather/main.php?id='.$_SESSION['athlete_id']);
	}
	if (isset($_SESSION['token'])) {
		$athlete = getStravaItem($_SESSION['token'], "https://www.strava.com/api/v3/athlete");
		$totals = getStravaItem($_SESSION['token'], "https://www.strava.com/api/v3/athletes/".$_SESSION['athlete_id']."/stats");
		$activities = getStravaItem($_SESSION['token'], "https://www.strava.com/api/v3/athlete/activities");	
	}
	//current weather
	$currentWeather = getWeather($lat, $long);
	$sunrise = $currentWeather['daily']['data'][0]['sunriseTime'];
	$sunset = $currentWeather['daily']['data'][0]['sunsetTime'];
	$timezone = $currentWeather['timezone'];
	date_default_timezone_set($timezone);	
	$temp = $currentWeather['currently']['temperature'];
	$name = $currentWeather['currently']['summary'];
	$wind = $currentWeather['currently']['windSpeed'];
	$time = $currentWeather['currently']['time'];
	$time = date('d/m/y H:i', $time); //do this when echoing
	
	include 'header.php';
?>
<div id="wrapper">
	<div id="profile-info">
		<img src=<?php echo varQuotes($athlete['profile']) ?>>	
		<?php 
			$total_distance = round(($totals['all_ride_totals']['distance'] / 1000), 1);
			$total_time = round(($totals['all_ride_totals']['moving_time'] / 3600),1);
			$biggest_ride = round(($totals['biggest_ride_distance'] / 1000), 1);
			echo "<h1>".$athlete['firstname']." ".$athlete['lastname']."</h1>";
			echo "<p>".$athlete['city'].", ".$athlete['country']."</p>";
			echo "<p>Distance travelled: ".$total_distance."km</p>";
			echo "<p>Time taken: ".$total_time."hours</p>";
			echo "<p>Biggest ride: ".$biggest_ride."km</p>";
		?>
	</div>
	<div id="current-location">
			<?php
				echo "<p>Current location: <em>".$city.",".$country."</em></p>";
				echo "<h1>".round($temp,1)."C</h1>";
				echo "<p>".$name."</p>";
				echo "<p>Wind:".round($wind,1)."km/h</p>";
				echo "<p>".$time."</p>";
			?>
		<button id="current-loc-popup">Change current location</button>
		<div class="hidden popup">
			<div class="blanket"></div><!-- for opacity -->
			<div class="popup-content">
				<span class="exit-btn">x</span>
				<form method="POST" action=<?php echo "'main.php?id=".$_SESSION['athlete_id']."'" ?>>
					<!-- labels -->
					<p> New location: <input type="text" name="location" placeholder="city, country"> </p>
					<p> Set default: <input type="checkbox" name="to_default" value="checked"></p>
					<button type="submit">Change</button>
				</form>
			</div>
		</div>
	</div>

	<div id="main-content">
		<h1 class="white">48 Hour Wind Graph of <?php echo $city ?></h1>

		<h2 class="white"><?php $currentWeather['hourly']['summary'] ?></h2>
		<div id="wind-graph">
			<?php 
				foreach ($currentWeather['hourly']['data'] as $weatherItem) {
					//invisible div with top border orange. orange color for temp and blue color for blah. time at bottom. blue and orange legend. 
					$temp = $weatherItem['temperature'];
					$name = $weatherItem['summary'];
					$wind = $weatherItem['windSpeed'];
					$time = $weatherItem['time'];
					$windArray[$time] = $wind;
					$time = date('d/m/y H:i ', $time);
					//innerdiv positioned absolutely
					echo "<div class='graphItem' id='".$wind."'><div class='innerGraphItem' id='".$temp."'> <span class='windMeasure'>".round($wind)."</span><span class='tempMeasure'>".round($temp)."</span></div></div>";
				}
			?>			
		</div>
		<ul class="flexlist">
			<?php
				foreach ($currentWeather['daily']['data'] as $weatherItem) {
					$minTemp = $weatherItem['temperatureMin'];
					$minTempTime = date('d/m/y H:i ',$weatherItem['temperatureMinTime']);
					$maxTemp = $weatherItem['temperatureMax'];
					$maxTempTime = date('d/m/y H:i ', $weatherItem['temperatureMaxTime']);
					$name = $weatherItem['summary'];
					$wind = $weatherItem['windSpeed'];
					$time = date('d/m/y H:i ',$weatherItem['time']);
					echo "<li class='item'>";
							echo "<h1>Min: ${minTemp}C at $minTempTime</h1>";
							echo "<h1>Max: ${maxTemp}C at $maxTempTime</h1>";
							echo "<p>$name </p>";
							echo "<p>Wind: ${wind}km/h</p>";
							echo "<p>$time</p>";
					echo "</li>";
				}
			?>
		</ul>	
		<div id="strava-data">
			<h2 class="white">Recent activities:</h2> 
			<a href=<?php echo "'activities.php?id=".$_SESSION['athlete_id']."'" ?> class="white">See all <?php echo count($activities) ?> activities.</a>
			<ul class="flexlist">
			<?php
				//onclick see graph of wind. mb plotted against speed
				for ($i=0; $i < 5; $i++) { 
					$name = $activities[$i]['name'];
					$date = strtotime($activities[$i]['start_date_local']);
					$date = date('d/m/y H:i ', $date);
					$avg_speed = $activities[$i]['average_speed'];
					$avg_speed = Conversion::msToKmh($avg_speed);
					$distance = $activities[$i]['distance'];
					$distance /= 1000;
					//min max wind speeds
					$startTime = strtotime($activities[$i]['start_date']);
					$weather = getWeather($activities[$i]['start_latlng'][0], $activities[$i]['start_latlng'][1],$startTime);
					$wind = $weather['currently']['windSpeed'];
					echo "<li class='item stretch'>"; 
					echo "<p>$name</p>";
					echo "<p>$date</p>";
					echo "<p>${avg_speed}km/h</p>";
					echo "<p>${distance}km</p>";
					echo "<p>wind speed: ${wind}km/h</p>";
					echo "</li>"; 
				}
			?>
			</ul>
		</div>
	</div>
</div>	
<?php include 'footer.php' ?>
