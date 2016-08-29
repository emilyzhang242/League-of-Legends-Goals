<!DOCTYPE html>
<html>
<head>
	<title>LOL Goals: Champion Information</title>

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

	<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>	
	<link href="css/styles.css" rel="stylesheet">

	<script type="text/javascript" src="js/ui_js/jquery-ui.js"></script>
	<script type="text/javascript" src="js/ui_js/jquery-ui.min.js"></script>
	<link href="css/ui_css/jquery-ui.css" rel="stylesheet">

	<script type="text/javascript" src="js/userstats.js"></script>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">

</head>
<body>
	<!-- start: Navigation Bar --> 
	<?php include 'header.php' ?>
	<!-- end: Navigation Bar --> 
	<div class='container' id='main-container'>
		<div class='row text-center' id='main-content'>
			<div class='col-md-12' id='loaded-content'>
				<p id='content' class='loading'></p>
				<?php

				include_once 'php/config.php';

				$array = array();

				if (isset($_GET['go'])) {
					$region = filter_input(INPUT_GET, 'region', FILTER_SANITIZE_STRING);
					$summoner = strtolower(str_replace(" ", "", filter_input(INPUT_GET, 'summoner', FILTER_SANITIZE_STRING)));
					$elo = filter_input(INPUT_GET, 'elo', FILTER_SANITIZE_STRING);

					$response = file_get_contents('https://na.api.pvp.net/api/lol/'.$region.'/v1.4/summoner/by-name/'.$summoner.'?api_key=6a4fae8d-a82c-4fa6-b797-042dbdc2fa72');
						//if summoner exists
					if (!empty($response)) {	
						$array = json_decode($response, true);
						$id = $array[$summoner]['id'];
						$icon_id = $array[$summoner]['profileIconId'];
						$year = strval(date("Y"));
							//check database for user to see if exists!
						$result = $mysqli->query("SELECT summID FROM Summoners 
							WHERE summID=$id");
						$row = $result->fetch_assoc();
						//if user doesn't exist in database
						if (empty($row)) {
							//loading bar: USE JQUERY TO CHANGE IT!!!
							echo '<div class="progress center-block summdb" id="process-data">';
							echo '<div class="progress-bar progress-bar-striped progress-bar-danger active" id="bar" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">';
							echo 'Adding Summoner to Database';
							echo '</div></div>';
							//sql add into summoners database
							$mysqli->query("INSERT INTO Summoners
								VALUES('$id', '$summoner', CURRENT_TIMESTAMP, NULL, NULL)");
							echo "<span class='usernotexist' data-summ=$summoner data-year=$year data-summid=$id data-icon=$icon_id data-elo=$elo id='successInsert'></span>";
						// if user already exists in database
						}else{
							// make sure summoner name is still the same
							$namecheck = $mysqli->query("SELECT * FROM Summoners WHERE summID=$id");
							$name_row = $namecheck->fetch_assoc();
							if ($summoner !== $name_row['summName']) {
								$mysqli->query("UPDATE Summoners SET summName=$summoner WHERE summID=$id");
							}
							// call python script and check number of games
							// ob_start();
							// include 'calc_match_length.php';
							// $numgames = ob_get_clean();

								// also update json file if needed
								// check database table and match with the number of games, if > 20 difference or if number of games < 50, then update stats 
									// first call api to get number of games 
									// then call database to compare games
									// then call api to get/update tier
								//otherwise just show the stats + most recent games (?)
								//check username in DB and make sure don't have to change 
								// check tier + division 

							echo '<div class="progress center-block summdb" id="process-data">';
							echo '<div class="progress-bar progress-bar-striped progress-bar-warning active" id="bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:10%">';
							echo 'Starting Calculations';
							echo '</div></div>';

							echo "<span class='userexists' data-summ=$summoner data-year=$year data-summid=$id data-icon=$icon_id data-elo=$elo id='successInsert'></span>";

						}
					}else {
						echo "<p class='warning'>That username doesn't exist! Please enter an existing username!</p>";
					}
				}else{
					echo "<p class='warning'>Please enter a username and region above to get stats!</p>";
				}
				?>
			</div>
		</div>
	</div>
</body>
</html>