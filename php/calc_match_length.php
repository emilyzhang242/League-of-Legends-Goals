<?php
$summoner = $_POST['summoner'];
$id = intval($_POST['summid']);
$year = strval(date("Y"));
ini_set('max_execution_time', 1200);
$abs_path = realpath("../py/calc_match_length.py"); 
$handle = popen("python $abs_path $summoner $year $id", 'r');

while(!feof($handle)) {
	$buffer = fgets($handle);
	echo $buffer;
}

pclose($handle);

?>