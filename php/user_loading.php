<?php

$summoner = $_POST['summoner'];
$id = $_POST['summid'];
$year = strval(date("Y"));
ini_set('max_execution_time', 1200);
$abs_path = realpath("../py/get_matchlist.py"); 
$handle = popen("python $abs_path $summoner $year $id", 'r');
pclose($handle);

$numgames = intval($_POST['numgames']);
$yearname = "numGames".$year;
$id = intval($id);

include_once 'config.php';
$mysqli->query("UPDATE Summoners
					SET $yearname = $numgames
					WHERE summID=$id");

?>