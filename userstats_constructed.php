<?php
$id = filter_input(INPUT_GET, 'summid', FILTER_SANITIZE_NUMBER_INT);
$elo = filter_input(INPUT_GET, 'elo', FILTER_SANITIZE_STRING);
$separate = strpos($elo, "_");
$tier = strtoupper(trim(substr($elo, 0, $separate)));
$division = trim(substr($elo, $separate+1));


include_once 'php/config.php';

$info_request = $mysqli->query("SELECT * FROM SummStats WHERE summID=$id");
$info_row = $info_request->fetch_assoc();

$wb20 = array();
$wp20 = array();
$lb20 = array();
$lp20 = array();

$categories = array('wb20', 'wp20', 'lb20', 'lp20');

foreach ($info_row as $key => $info) {
	foreach ($categories as $category) {
		if (strpos($key, $category) !== false) {
			$start = sizeof($category)+4;
			$new_key = substr($key, $start);
			${$category}[$new_key] = round($info, 2);
		}
	}
}

//get division average 
$av = $mysqli->query("SELECT AVG(wb20_kills), AVG(wb20_deaths), AVG(wb20_assists), AVG(wb20_wards), AVG(wb20_cs10), AVG(wb20_cs20), AVG(wb20_gold), AVG(lb20_kills), AVG(lb20_deaths), AVG(lb20_assists), AVG(lb20_wards), AVG(lb20_cs10), AVG(lb20_cs20), AVG(lb20_gold), AVG(wp20_kills), AVG(wp20_deaths), AVG(wp20_assists), AVG(wp20_teamcc), AVG(lp20_kills), AVG(lp20_deaths), AVG(lp20_assists), AVG(lp20_teamcc) FROM SummStats 
	WHERE tier='$info_row[tier]' AND division='$info_row[division]'");
$counter = 0;
$mcounter = 0;
$old_row = $av->fetch_array();
$row = array();
for ($x=0; $x < sizeof($old_row); $x++) {
	$row[] = round($old_row[$x], 2);
}

//get wanted average
$wanted_av = $mysqli->query("SELECT AVG(wb20_kills), AVG(wb20_deaths), AVG(wb20_assists), AVG(wb20_wards), AVG(wb20_cs10), AVG(wb20_cs20), AVG(wb20_gold), AVG(lb20_kills), AVG(lb20_deaths), AVG(lb20_assists), AVG(lb20_wards), AVG(lb20_cs10), AVG(lb20_cs20), AVG(lb20_gold), AVG(wp20_kills), AVG(wp20_deaths), AVG(wp20_assists), AVG(wp20_teamcc), AVG(lp20_kills), AVG(lp20_deaths), AVG(lp20_assists), AVG(lp20_teamcc) FROM SummStats 
	WHERE tier='$tier' AND division='$division'");
$wanted_counter = 0;
$wanted_old_row = $wanted_av->fetch_array();
$wanted_row = array();
for ($x=0; $x < sizeof($wanted_old_row); $x++) {
	$wanted_row[] = round($wanted_old_row[$x], 2);
}

$your_elo = $info_row['tier']." ".$info_row['division'];

?>
<!-- START: USERNAME BLOCK -->
<div class='container-fluid'>
	<div class='row' id='userrow'>
		<div class='col-sm-12' id='userbox'>
			<?php 
			// summoner icon
			$icon = filter_input(INPUT_GET, 'icon', FILTER_SANITIZE_NUMBER_INT);
			$icon_url = "http://ddragon.leagueoflegends.com/cdn/6.7.1/img/profileicon/".$icon.".png";;
			//username
			$summ = filter_input(INPUT_GET, 'summoner', FILTER_SANITIZE_STRING);
			$summ = strtoupper($summ);
			echo "<div class='col-sm-1'><img id='summicon' class='pull-left' src='$icon_url' style='width: 75px; height: 75px'></div>";
			echo "<div class='col-sm-11'>";
			echo "<h3 id='username'>$summ</h3>"; 
			echo "<p class='small-stats'>$info_row[tier] $info_row[division]</p><br>";
			echo "<p class='small-stats pull-left'>$info_row[numWins]W / $info_row[numLosses]L</p>";
			echo "</div>";
			?>
		</div>
	</div>
</div>
<!-- END: USERNAME BLOCK -->
<div class='container-fluid'>
	<div class='row separator'>
	</div>
	<div class='row'>
		<div class='col-sm-8'>
			<div class='row' id='calc_stats'>
				<p>Hover over table headers for more information!</p>
				<!-- START: GENERAL STATS TABLE -->
				<div class='col-sm-5'>
					<div class='row'>
						<div class='col-sm-12 stats-div'>
							<?php
							echo "<p> <img class='img-descrip' src='image/elos/$info_row[tier].png'> Your Average </p>";
							echo "<table width='90%' class='table table-condensed'>";
							echo "<tbody>";
							echo "<thead><tr><th class='table-info' title='' id='metric1'>Metric</th><th class='table-info' title='' id='wins1'>Wins</th><th title='' class='table-info' id='losses1'>Losses</th></tr></thead>";
							foreach ($wb20 as $key => $value) {
								echo "<tr>";
								$new_key = strtoupper($key);
								echo "<td class='stats-font'>$new_key</td>";
								$color = "#8bb381"; 
								if ($row[$counter] > $value) {
									$color = "#c24641"; 
								}
								echo "<td class='stats-font'><span style='color: $color'>$value </span>[$row[$counter]]</td>";
								//losses
								$loss_counter = $counter+7;
								$loss_color = "#8bb381"; 
								if ($row[$loss_counter] > $lb20[$key]) {
									$loss_color = "#c24641"; 
								}
								echo "<td class='stats-font'><span style='color: $loss_color'>$lb20[$key]</span> 
								[$row[$loss_counter]]</td>";
								$counter = $counter + 1;
								echo "</tr>";
							}
							echo "</tbody>";
							echo "</table>";
							$counter = $counter + 7;
							?>
						</div>
					</div>
					<div class='row'>
						<div class='col-sm-12 stats-div'>
							<?php
							echo "<table width='90%' class='table table-condensed'>";
							echo "<tbody>";
							echo "<thead><tr><th></th><th></th><th></th></tr></thead>";
							foreach ($wp20 as $key => $value) {
								echo "<tr>";
								$new_key = strtoupper($key);
								echo "<td class='stats-font'>$new_key</td>";
								$color = "#8bb381"; 
								if ($row[$counter] > $value) {
									$color = "#c24641"; 
								}
								echo "<td class='stats-font'><span style='color: $color'>$value </span>[$row[$counter]]</td>";
						// losses
								$loss_counter = $counter+4;
								$loss_color = "#8bb381"; 
								if ($row[$loss_counter] > $lp20[$key]) {
									$loss_color = "#c24641"; 
								}
								echo "<td class='stats-font'><span style='color: $loss_color'>$lp20[$key]</span> 
								[$row[$loss_counter]]</td>";
								$counter = $counter + 1;
						//$mcounter = $mcounter + 2;
								echo "</tr>";
							}
							echo "</tbody>";
							echo "</table>";
							?>
						</div>
					</div>
				</div>
				<!-- END: GENERAL STATS TABLE -->

				<div class='col-sm-2'>
					<p id='pre-20'> PRE-20 </p>
					<h1 id='comparator'>VS</h1>
					<p id='post-20'> POST-20 </p>
				</div>
				<!-- START: COMPARISON STATS TABLE -->
				<div class='col-sm-5'>
					<div class='row'>
						<div class='col-sm-12 stats-div'>
							<?php
							echo "<p> <img class='img-descrip' src='image/elos/$tier.png'> $tier $division Average</p>";
							echo "<table width='90%' class='table table-condensed'>";
							echo "<tbody>";
							echo "<thead><tr><th class='table-info' title='' id='metric2'>Metric</th><th class='table-info' title='' id='wins2'>Wins</th><th class='table-info' title='' id='losses2'>Losses</th></tr></thead>";
							foreach ($wb20 as $key => $value) {
								echo "<tr>";

								$new_key = strtoupper($key);
								echo "<td class='stats-font'>$new_key</td>";

								$color = "#8bb381"; 
								if ($wanted_row[$wanted_counter] > $value) {
									$color = "#c24641"; 
								}
								$diff = $value - $wanted_row[$wanted_counter];
								echo "<td class='stats-font'>$wanted_row[$wanted_counter] <span style='color: $color'>[$diff]</span></td>";
								$wanted_loss_counter = $wanted_counter+7;
								$loss_diff = $lb20[$key] - $wanted_row[$wanted_loss_counter];
								$loss_color = "#8bb381"; 
								if ($wanted_row[$wanted_loss_counter] > $lb20[$key]) {
									$loss_color = "#c24641"; 
								}
								echo "<td class='stats-font'>$wanted_row[$wanted_loss_counter] <span style='color: $loss_color'>[$loss_diff]</span></td>";
								$wanted_counter = $wanted_counter + 1;
						//$mcounter = $mcounter + 2;
								echo "</tr>";
							}
							echo "</tbody>";
							echo "</table>";
							$wanted_counter = $wanted_counter + 7;
							?>
						</div>
					</div>
					<div class='row'>
						<div class='col-sm-12 stats-div'>
							<?php
							echo "<table width='90%' class='table table-condensed'>";
							echo "<tbody>";
							echo "<thead><tr><th></th><th></th><th></th></tr></thead>";
							foreach ($wp20 as $key => $value) {
								echo "<tr>";

								$new_key = strtoupper($key);
								echo "<td class='stats-font'>$new_key</td>";

								$color = "#8bb381"; 
								if ($wanted_row[$wanted_counter] > $value) {
									$color = "#c24641"; 
								}
								$diff = $value - $wanted_row[$wanted_counter];
								echo "<td class='stats-font'>$wanted_row[$wanted_counter] <span style='color: $color'>[$diff]</span></td>";
								$wanted_loss_counter = $wanted_counter+4;
								$loss_diff = $lp20[$key] - $wanted_row[$wanted_loss_counter];
								$loss_color = "#8bb381"; 
								if ($wanted_row[$wanted_loss_counter] > $lp20[$key]) {
									$loss_color = "#c24641"; 
								}
								echo "<td class='stats-font'>$wanted_row[$wanted_loss_counter] <span style='color: $loss_color'>[$loss_diff]</span></td>";
								$wanted_counter = $wanted_counter + 1;
								echo "</tr>";
							}
							echo "</tbody>";
							echo "</table>";
							?>
						</div>
					</div>
				</div>
				<!-- END: COMPARISON STATS TABLE -->
			</div>
		</div>

		<div class='col-sm-4'>
			<div class='tip_bar'> 
				Tips:
				<br>
				<br>
				<?php
					//tip for current rank
				if(($row[0]-$wb20["kills"]>=1)||($row[14]-$wp20["kills"]>=3)){
					echo "You are falling behind on kills in your current rank for games won. Please work on getting more kills.";
					echo "<br>";echo "<br>";
				}
				elseif(($wb20["kills"]-$row[0]>=1)&&($wp20["kills"]-$row[14]>=3)){
					echo "You are getting a lot more kills than your current rank for games won. Good job!";
					echo "<br>";
					echo "<br>";
				}
				else{
					echo "You're getting about the same amount of kills as most people do in your rank for games won. Keep up!";
					echo "<br>";
					echo "<br>";
				}
				if(($row[7]-$lb20["kills"]>=1)||($row[18]-$lp20["kills"]>=3)){
					echo "You are falling behind on kills in your current rank for games lost. Please work on getting more kills.";
					echo "<br>";
					echo "<br>";
				}
				elseif(($lb20["kills"]-$row[7]>=1)&&($lp20["kills"]-$row[18]>=3)){
					echo "You are getting a lot more kills than your current rank for games lost. Good job!";
					echo "<br>";
					echo "<br>";
				}
				else{
					echo "You're getting about the same amount of kills as most people do in your rank for games lost. Keep up!";
					echo "<br>";
					echo "<br>";
				}
					//tip for wantedrank
				if(($wanted_row[0]-$wb20["kills"]>=1)||($wanted_row[14]-$wp20["kills"]>=3)){
					echo "You are falling behind on kills in your goal rank for games won. Please work on getting more kills.";
					echo "<br>";
					echo "<br>";
				}
				elseif(($wb20["kills"]-$wanted_row[0]>=1)&&($wp20["kills"]-$wanted_row[14]>=3)){
					echo "You are getting a lot more kills than your goal rank for games won. Good job!";
					echo "<br>";
					echo "<br>";
				}
				else{
					echo "You're getting about the same amount of kills as most people do in your goal rank games won. Keep up!";
					echo "<br>";
					echo "<br>";
				}
				if(($wanted_row[7]-$lb20["kills"]>=1)||($wanted_row[18]-$lp20["kills"]>=3)){
					echo "You are falling behind on kills in your goal rank for games lost. Please work on getting more kills.";
					echo "<br>";
					echo "<br>";
				}
				elseif(($lb20["kills"]-$wanted_row[7]>=1)&&($lp20["kills"]-$wanted_row[18]>=3)){
					echo "You are getting a lot more kills than your goal rank for games lost. Good job!";
					echo "<br>";
					echo "<br>";
				}
				else{
					echo "You're getting about the same amount of kills as most people do in your goal rank for games lost. Keep up!";
					echo "<br>";
					echo "<br>";
				}
				?>
			</div>
			<div class='row separator'></div>
			<div class='row' id= 'data-count'>
				<div class='col-sm-5'>
					<img id='data-img' src='image/data-count.png'>
				</div>
				<div class='col-sm-7'>
					<p id='data-txt'>
						<?php 

						$your_tier = $info_row['tier'];
						$your_division = $info_row['division'];

						$count_your_div = $mysqli->query("SELECT COUNT(*) FROM SummStats WHERE tier='$your_tier' AND division='$your_division'");
						$count_val = $count_your_div->fetch_array();

						$count_other_div = $mysqli->query("SELECT COUNT(*) FROM SummStats WHERE tier='$tier' AND division='$division'");
						$count_val2 = $count_other_div->fetch_array();

						echo "Hey there, Summoner!<br>You might be wondering just exactly how many people you're being compared to!<br><br>
							# in $your_elo: $count_val[0]<br>
							# in $tier $division: $count_val2[0]";
						?>
					</p>
				</div>
			</div>
		</div>
	</div> 
</div>
