<?php 

include_once 'config.php';

$info = $_POST['info'];;
$delimiter = $_POST['delimiter'];
$summid = strval($_POST['summid']);
$array = explode($delimiter, $info);

//calculate tier information 
$request = file_get_contents("https://na.api.pvp.net/api/lol/na/v2.5/league/by-summoner/".$summid."?api_key=6a4fae8d-a82c-4fa6-b797-042dbdc2fa72");
$data = json_decode($request, true);
$tier = $data[$summid][0]['tier'];
$division = "";
$entries = $data[$summid][0]['entries'];
foreach ($entries as $summdata) {
	if ($summdata['playerOrTeamId'] == $summid) {
		$division = $summdata['division'];
	}
}

$result = $mysqli->query("INSERT INTO SummStats 
						VALUES('$summid', '$tier', '$division', CURRENT_TIMESTAMP, '$array[0]', '$array[1]', '$array[2]', '$array[3]', '$array[4]', '$array[5]', '$array[6]', '$array[7]', '$array[8]', '$array[9]', '$array[10]', '$array[11]', '$array[12]', '$array[13]', '$array[14]', '$array[15]', '$array[16]', '$array[17]', '$array[18]', '$array[19]', '$array[20]', '$array[21]', '$array[22]', '$array[23]')");

//turn array back into string to bring into javascript
$minmax= "";
for ($x=24; $x < sizeof($array)-2; $x++) {
	$minmax = $minmax.strval($array[$x]).$delimiter;
}

echo $minmax;

?>