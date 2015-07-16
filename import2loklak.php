<?php

$LOKLAK_PUSH_URL = 'http://localhost:9000/api/push/';

$urls = file_get_contents('urls.json');
$urls = json_decode($urls, true);

foreach ($urls['ffmap'] as $key => $value) {
	$query_data = array(
		'url' => $value
	);
	$result = file_get_contents($LOKLAK_PUSH_URL . 'freifunknode.json?' . http_build_query($query_data));
}

foreach ($urls['owm'] as $key => $value) {
	$query_data = array(
		'url' => $value
	);
	$result = file_get_contents($LOKLAK_PUSH_URL . 'openwifimap.json?' . http_build_query($query_data));
}

foreach ($urls['nodelist'] as $key => $value) {
	$query_data = array(
		'url' => $value
	);
	$result = file_get_contents($LOKLAK_PUSH_URL . 'nodelist.json?' . http_build_query($query_data));
}

foreach ($urls['netmon'] as $key => $value) {
	$query_data = array(
		'url' => $value
	);
	$result = file_get_contents($LOKLAK_PUSH_URL . 'netmon.json?' . http_build_query($query_data));
}