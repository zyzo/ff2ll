<?php

$urls = file_get_contents('urls.json');
$urls = json_decode($urls, true);

$statuses = array();

foreach ($urls as $value) {
	foreach ($value as $url) {
		$statuses[$url] = 'bad';
	}
}

foreach ($statuses as $url => $status) {
	echo 'Checking ' . $url . PHP_EOL;
	if (file_get_contents($url)) {
		$statuses[$url] = 'good';
	}
}

$result = json_encode($statuses, JSON_PRETTY_PRINT);
echo $result;
$fp = fopen('pingResult.json', 'w+');
fwrite($fp, $result);
fclose($fp);