<?php
$delimiter = $_POST['delimiter'];
$id = $_POST['summid'];
$year = strval(date("Y"));
ini_set('max_execution_time', 1200);
$abs_path = realpath("../py/make_calculations.py");
$handle = popen("python $abs_path $id $year", 'r');
while(!feof($handle)) {
	$buffer = fgets($handle);
	echo "$buffer$delimiter";
}
pclose($handle);

?>