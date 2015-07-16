<?php

class FF2LL {

	const FREIFUNK_DIRECTORY = "comList.json";
	const LOKLAK_URL = "http://localhost:9000";

	public function run() {
		$directory = file_get_contents(FF2LL::FREIFUNK_DIRECTORY);
		$directory = json_decode($directory, true);
		$urls = array(
			"ffmap" => [],
			"netmon" => [],
			"nodelist" => [],
			"owm" => []
		);

		foreach ($directory as $value) {
			echo 'Processing '. $value . '..' . PHP_EOL;
			$comFile = file_get_contents('comFiles/' . $value . '.json');
			$comFile = json_decode($comFile, true);
			if (!array_key_exists('nodeMaps', $comFile)) {
				echo 'Nodemaps not found' . PHP_EOL;
				continue;
			}
			foreach ($comFile['nodeMaps'] as $node) {
				$found = false;
				if (array_key_exists('technicalType', $node)) {
					switch ($node['technicalType']) {
						case 'ffmap':
							$found = array_key_exists('url', $node);
							if ($found) {
								array_push($urls['ffmap'], $this->fromFFMap($node['url']));
							}
							break;
						case 'netmon':
							$found = $node['mapType'] === 'list/status';
							if ($found) {
								array_push($urls['netmon'], $this->fromNetmon($node['url']));
							}
							break;
						case 'openwifimap':
							$found = $node['mapType'] === 'geographical';
							if($found) {
								array_push($urls['owm'], $this->fromOpenWifiMap($node['url']));
							}
							break;
						case 'nodelist':
							$found = $node['mapType'] === 'list/status';
							if ($found) {
								array_push($urls['nodelist'], $node['url']);
							}
							break;
						default:
							break;
					}
					if ($found) break;
				}
			}
		}
		$fp = fopen('urls.json', 'w+');
		fwrite($fp, json_encode($urls, JSON_PRETTY_PRINT));
		fclose($fp);
	}

	private function fromFFMap($url) {
		$parsedUrl = parse_url($url);
		if (!array_key_exists('host', $parsedUrl)) {
			// bizarre case, just append to origin
			return $url . '/node.json';
		}
		$mappos = strpos($parsedUrl['path'], '/map/');
		if ($mappos) {
			return '//' . $parsedUrl['host'] . '/map/nodes.json';
		} else {
		return '//' . $parsedUrl['host'] . '/nodes.json';
		}
	}

	private function fromNetmon($url) {
		// remove routerlist.php suffix
		$url = substr($url, 0, -strlen('routerlist.php'));
		$url = rtrim($url, '/').'/api/rest/api.php';
		$url .= '?'.http_build_query(
						array(
							'rquest' => 'routerlist',
							'limit' => 1000,			// one day this will be not enough - TODO. add loop
							'sort_by' => 'router_id'
						)
				);
		return $url;
	}

	private function fromOpenWifiMap($url) {
		$url .= '/api/view_nodes';
		return $url;
	}
}

$ff2ll = new FF2LL();
$ff2ll->run();
