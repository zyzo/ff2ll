<?php

$FREIFUNK_DIRECTORY = "https://raw.githubusercontent.com/freifunk/directory.api.freifunk.net/master/directory.json";

$directory = file_get_contents($FREIFUNK_DIRECTORY);
$directory = json_decode($directory);

$comShortList = array();

$success= 0;
$count = count($directory);
foreach ($directory as $key => $value) {
	echo 'Downloading ' . $key . '..';
	try {
		$commFile = file_get_contents($value);
	} catch (Exception $e) {
		echo 'Problem retrieving file from ' . $key . PHP_EOL . $value;
		continue;
	}
	if (!$commFile) {
		echo 'Problem retrieving file from ' . $key . PHP_EOL . $value;
		continue;
	}
	$success++;
	array_push($comShortList, $key);
	$fp = fopen('comFiles/' . $key . '.json', 'w+');
	fwrite($fp, $commFile);
	fclose($fp);
}

$fp = fopen('comList.json', 'w+');
fwrite($fp, json_encode($comShortList));
fclose($fp);

echo 'Total number of communities : ' . $count . ', success : ' . $success;
