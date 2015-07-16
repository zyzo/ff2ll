<?php

$LOKLAK_PUSH_URL = 'http://localhost:9000/api/push/';

$urls = file_get_contents('urls.json');
$urls = json_decode($urls, true);
$pingResult = file_get_contents('pingResult.json');
$pingResult = json_decode($pingResult, true);

echo 'Importing ffmap' .PHP_EOL;
foreach ($urls['ffmap'] as $key => $value) {
	if ($pingResult[$value] === 'bad') {
		continue;
	}
	$query_data = array(
		'url' => $value
	);
	$result = file_get_contents($LOKLAK_PUSH_URL . 'freifunknode.json?' . http_build_query($query_data));
}

echo 'Importing openwifimap' .PHP_EOL;
foreach ($urls['owm'] as $key => $value) {
	if ($pingResult[$value] === 'bad') {
		continue;
	}
	$query_data = array(
		'url' => $value
	);
	echo 'Importing ' . $value .PHP_EOL;
	$result = file_get_contents($LOKLAK_PUSH_URL . 'openwifimap.json?' . http_build_query($query_data));
}

echo 'Importing nodelist' .PHP_EOL;
foreach ($urls['nodelist'] as $key => $value) {
	if ($pingResult[$value] === 'bad') {
		continue;
	}
	$query_data = array(
		'url' => $value
	);
	echo 'Importing ' . $value .PHP_EOL;
	$result = file_get_contents($LOKLAK_PUSH_URL . 'nodelist.json?' . http_build_query($query_data));
}

echo 'Importing netmon' .PHP_EOL;
foreach ($urls['netmon'] as $key => $value) {
	if ($pingResult[$value] === 'bad') {
		continue;
	}
	$query_data = array(
		'url' => $value
	);
	echo 'Importing ' . $value .PHP_EOL;
	$result = file_get_contents($LOKLAK_PUSH_URL . 'netmon.json?' . http_build_query($query_data));
}