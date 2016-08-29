<!DOCTYPE html>
<html>
<head>
	<title>LOL Goals: Champion Information</title>

	<link href="css/styles.css" rel="stylesheet">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script type="text/javascript" src="js/champions.js"></script>

	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.11/css/jquery.dataTables.css">
	<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.11/js/jquery.dataTables.js"></script>

	<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>	

	<script type="text/javascript" src="js/ui_js/jquery-ui.js"></script>
	<script type="text/javascript" src="js/ui_js/jquery-ui.min.js"></script>
	<link href="css/ui_css/jquery-ui.css" rel="stylesheet">

	<link href="css/tooltip.css" rel="stylesheet">
	<link href="css/champions.css" rel="stylesheet">

	<script>
		$(document).ready(function () {
			$('#champ-table').DataTable({
				destroy: true, 
				paging: false
			});
		});
	</script>

	<!-- START: PHP -->
	<?php

	$champs = array();
	#the different possible stats e.g. Strong Early, etc. 
	$stats = array();
	$aspects = array();

	function gen_champ_names() {

		global $champs;

		$row = 1;
		if (($handle = fopen("./csv/stats_by_role.csv", "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
				if ($row !== 1) {
					//name => 1; role => 2
					$champs[$row-2][] = htmlentities($data[1]);
					$champs[$row-2][] = $data[2];
					//DELETE LATER
				}
				$row++;
			}
		}   
		fclose($handle);
	}

	function configure_stats() {

		global $champs, $stats;

		$row = 1;
		if (($handle = fopen("./csv/stats_by_role.csv", "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				$num = count($data);
				if ($row == 1) {
					for ($c=0; $c < $num; $c++) {
						$stats[] = $data[$c];
					}
				}else{
					for ($c=0; $c < $num; $c++) {
                        #if true value, then append stat name to global array
						if ($data[$c] === "TRUE") {
							$champs[$row-2][] = $stats[$c];
						}
					}
				}
				$row++;
			}
		}
		fclose($handle);   
	}

	function configure_aspects() {

		global $champs, $aspects;

		$row = 1;
		if (($handle = fopen("./csv/champ_stats.csv", "r")) !== FALSE) {
			while (($data = fgetcsv($handle, ",")) !== FALSE) {
				$num = count($data);
				if ($row == 1) {
					for ($c=0; $c < $num; $c++) {
						$aspects[] = $data[$c];
					}
				}else{
					for ($c=0; $c < $num; $c++) {
						$role = $champs[$row-2][1];
                        #if true value, then append stat name to global array
						if ($data[$c] === "TRUE") {
							$champs[$row-2][] = $aspects[$c];
						}
					}
				}
				$row++;
			}
		}
		fclose($handle);   
	}     

	function create_table($champs) {

		global $champs;

		for ($x=0; $x<sizeof($champs); $x++) {
			build_row($champs[$x][0], $champs[$x][1], $champs[$x]);
		}
	}


	function create_sort_table($champs) {

		global $champs;

		global $strength, $role;
		#array to keep track of conditions that the user inputs
		$match = True;
		$conditions = array("strength" => $strength, "role" => $role);

		for ($x=0; $x < sizeof($champs); $x++) {

			if (($role != $champs[$x][1] && $role != "") || (in_array($strength." Primary", $champs[$x]) == False) && $strength != "") {
				continue;
			}else {
				build_row($champs[$x][0], $champs[$x][1], $champs[$x]);
			}
			
		}
	}


	function build_row($champ, $role, $array) {

		$weird_champs = ["Vel'Koz", "Kha'Zix", "Rek'Sai", "Cho'Gath", "Kog'Maw"];
		$changed = ["VelKoz", "KhaZix", "RekSai", "ChoGath", "KogMaw"];

		echo "<tr>";
		if (in_array($champ, $weird_champs)) {
			for($x=0; $x<sizeof($weird_champs); $x++) {
				if ($champ == $weird_champs[$x]) {
					//echo $changed[$x];
					echo "<td><img src='image/champions/".$changed[$x]."Square.png'>&nbsp;&nbsp;<a href='http://leagueoflegends.wikia.com/wiki/$champ'>$champ</td>";
				}
			}
		}else{
			echo "<td><img src='image/champions/".$champ."Square.png'>&nbsp;&nbsp;<a href='http://leagueoflegends.wikia.com/wiki/$champ'>$champ</td>";
		}
		echo "<td class='text-center'>$role</td>";
		echo "<td class='text-center'>";
		$color = check_color($array);
		if (in_array($champ, $weird_champs) == False) {
			echo "<div class='table_buttons $color[0] early' id='$champ"."-early"."' title='Hover again for Tooltip'>Early Game</div>
			<div class='table_buttons $color[1] mid' id='$champ"."-mid"."' title='Hover again for Tooltip'>Mid Game</div>
			<div class='table_buttons $color[2] late' id='$champ"."-late"."' title='Hover again for Tooltip'>Late Game</div>";
		}else{
			echo "<div class='table_buttons $color[0] early' id='$weird_champs[0]"."-early"."' title='Hover again for Tooltip'>Early Game</div><div class='table_buttons $color[1] mid' id='$weird champs[0]"."-mid"."' title='Hover again for Tooltip'>Mid Game</div><div class='table_buttons $color[2] late' id='$weird champs[0]"."-late"."' title='Hover again for Tooltip'>Late Game</div>";
		}	
		echo "</td>";
		echo "</tr>";
	}

	function check_color($champ) {
		$array = array();
		
		if (in_array('Strong Early Primary', $champ) == True) {
			$array[] = "strong";
		}elseif (in_array('Weak Early Primary', $champ) == True) {
			$array[] = "weak";
		}else{
			$array[] = "neither";
		}
		if (in_array('Strong Mid Primary', $champ) === True) {
			$array[] = "strong";
		}elseif (in_array('Weak Mid Primary', $champ) === True) {
			$array[] = "weak";
		}else{
			$array[] = "neither";
		}
		if (in_array('Strong Late Primary', $champ) == True) {
			$array[] = "strong";
		}elseif (in_array('Weak Late Primary', $champ) == True) {
			$array[] = "weak";
		}else{
			$array[] = "neither";
		}
		
		return $array;
	}

	gen_champ_names();
	configure_stats();
	//print_r($GLOBALS);

	// RUN THIS FUNCTION WHENEVER YOU WANT TO UPDATE THE STATISTICS OF THE TOOLTIPS. OTHERWISE, 
	// LEAVE IT ALONE!!!
	function update_champ_stats() {

		global $champs, $aspects;
		$delimiter = '|';
		$file = fopen("champ_stats.txt", 'w');   

		$row = 1;
		if (($handle = fopen("champ_stats.csv", "r")) !== FALSE) {
			while (($data = fgetcsv($handle, ",")) !== FALSE) {
				$num = count($data);
				if ($row == 1) {
					for ($c=0; $c < $num; $c++) {
						$aspects[] = $data[$c];
					}
				}else{
					$role = $champs[$row-2][1];
					$champ = $champs[$row-2][0];
					$line = $champ.$delimiter.$role.$delimiter;
					for ($c=0; $c < $num; $c++) {
                        #if true value, then append stat name to global array
						if ($data[$c] === "TRUE" && strpos($aspects[$c], $role) == True) {
							$line = $line.$aspects[$c].$delimiter;
						}
					}
					$line = $line."\n";
					fwrite($file, $line);
				}
				$row++;
			}
			fclose($file);
		}
		fclose($handle);   
	}
	?>
	<!-- END: PHP --> 

</head>
<body>

	<!-- start: Navigation Bar --> 
	<?php include 'header.php' ?>
	<!-- end: Navigation Bar --> 

<!-- 	<div class="container search_bar">
		<div class="row">
			<div class="col-md-3">
				<a href="index.php"><img id="logo" src='http://images.cooltext.com/4444951.png'></a>
			</div>
			<div class="col-md-9">
				<form class="navbar-form" role="search" action="userstats.php" method="post">
					<div class="input-group col-md-6" style="margin-top: 20px">
						<input type="text" style="width: 500px" class="form-control" placeholder="Please enter summoner name" name="srch-term" id="srch-term"/>
						<div class="input-group-btn">
							<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div> -->

	<!-- start: criteria selection -->

	<div class="container" id='main'>
		<div class="row" style="height: 30px">
			<p id='instructions'>Hover over strength filters with colors to get tooltips for each champion!<br> The search bar also allows you to filter by role.</p> 
		</div>
		<div class="row">
			<div class="col-md-3 search">
				<div id="filter">
					<form action="champions.php" method="post">
						<h3> Select the filters you'd like to apply.</h3>
						<label class="selection" for="strength_filter">Strength:</label>
						<select name="strength" id="strength_filter" class="pull-right input-sm"> 
							<option value="">--select--</option>
							<option value="Weak Early">Weak Early</option>
							<option value="Weak Mid">Weak Mid</option>
							<option value="Weak Late">Weak Late</option>
							<option value="Strong Early">Strong Early</option>
							<option value="Strong Mid">Strong Mid</option>
							<option value="Strong Late">Strong Late</option>
						</select>
						<br>
						<label class="selection" for="role">Role:</label>
						<select name="role" id="role" class="pull-right input-sm"> 
							<option value="">--select--</option>
							<option value="Fighter">Fighter</option>
							<option value="Tank">Tank</option>
							<option value="Support">Support</option>
							<option value="Marksman">Marksman</option>
							<option value="Mage">Mage</option>
						</select>
						<br>
						<input type="submit" name ="submit" value="Go!" class="pull-right" />
					</form>
				</div>
			</div>

			<!-- end: criteria selection -->

			<!-- start: table -->
			<div class="col-md-7" style="margin-top: 5%">
				<table class="table" id="champ-table" style="background-color: #222222">
					<thead>
						<tr>
							<th class='text-center'>Champion</th>
							<th class='text-center'>Role</th>
							<th class='text-center'>Strength</th>
						</tr>
					</thead>
					<tbody>
						<?php 

						if (!isset($_POST['submit'])) {
							create_table($champs);
						}elseif(isset($_POST['submit'])) {
							$strength = $_POST['strength'];
							$role = $_POST['role'];
							if ($strength == "" && $role == "") {
								create_table($champs);
							}else{
								$strength = $_POST['strength'];
								$role = $_POST['role'];
								create_sort_table($champs);
							}
						}

						?>
					</tbody>
				</table>
				<!-- end: table -->
			</div>
			<div class="span-md-2" id="empty_col"></div>
		</div>
	</div>

</body>
</html>