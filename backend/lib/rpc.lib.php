<?php

### Библиотека для биткоина ###

function btc_rpc ($query) {
	global $config;
	if (!isset ($config['btc']['host']) || !$config['btc']['host'] || !isset ($config['btc']['port']) || !$config['btc']['port']) critical_error ([
		'function' => __FUNCTION__,
		'cause' => 'btc config error'
	]);

	$ch = curl_init ("http://{$config['btc']['host']}:{$config['btc']['port']}/");
	
	curl_setopt ($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt ($ch, CURLOPT_USERPWD, '45EuP8sBbPvw4LUvgBB52Ap6YLBfT9Cu:Z74Pw4wAUuXjfXgnj9F5c2HVD3sHZRUd');
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt ($ch, CURLOPT_TIMEOUT, 15);
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 15);
	curl_setopt ($ch, CURLOPT_HEADER, false);
	curl_setopt ($ch, CURLOPT_POST, true);
	curl_setopt ($ch, CURLOPT_POSTFIELDS, $query);
	curl_setopt ($ch, CURLOPT_HTTPHEADER, [
		'Content-Type: application/json'
	]);
	curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt ($ch, CURLOPT_MAXREDIRS, 10);

	$result = curl_exec ($ch);

	curl_close ($ch);
 
	if (!$result) return null;
	$result = json_decode ($result);
	if (!$result) return null;

	return $result;
}

function btc_getblockcount () {
	$response = btc_rpc ('{"jsonrpc": "1.0", "id":"1", "method": "getblockcount", "params": []}');
	if (!$response || (is_object ($response) && $response->error)) {
		tech_log (['function' => __FUNCTION__, 'response' => $response]);
		return null;
	} else return $response->result;
}

# https://www.buybitcoinworldwide.com/fee-calculator/
function btc_settxfee ($fee_in_satoshis_per_byte) {
	$fee_in_btc_per_kb = ($fee_in_satoshis_per_byte * 1024) / TO_SATOSHI;
	$response = btc_rpc ('{"jsonrpc": "1.0", "id":"1", "method": "settxfee", "params": [' . $fee_in_btc_per_kb . ']}');
	if (!$response || (is_object ($response) && $response->error)) {
		tech_log (['function' => __FUNCTION__, 'response' => $response]);
		return null;
	} else return $response->result;
}

function btc_getnewaddress () { 
	$response = btc_rpc ('{"jsonrpc": "1.0", "id":"1", "method": "getnewaddress", "params": []}');
	if (!$response || (is_object ($response) && $response->error)) {
		tech_log (['function' => __FUNCTION__, 'response' => $response]);
		return null;
	} else return $response->result;
}

function btc_listtransactions ($page = 0) {
	$count = 100; # не думаю, что количество транзакций на странице стоит выносить в настройки
	$skip = $page * $count;
	$response = btc_rpc ('{"jsonrpc": "1.0", "id":"1", "method": "listtransactions", "params": ["*", ' . $count . ', ' . $skip . ']}');
	if (!$response || (is_object ($response) && $response->error)) {
		tech_log (['function' => __FUNCTION__, 'response' => $response]);
		return null;
	} else return $response->result;
}

function btc_sendtoaddress ($wallet, $amount) {
	$response = btc_rpc ('{"jsonrpc": "1.0", "id":"1", "method": "sendtoaddress", "params": ["' . $wallet . '", ' . $amount . ']}');
	if (!$response || (is_object ($response) && $response->error)) {
		tech_log (['function' => __FUNCTION__, 'response' => $response]);
		return null;
	} else return $response->result;
}

function btc_gettransaction ($txid) {
	$response = btc_rpc ('{"jsonrpc": "1.0", "id":"1", "method": "gettransaction", "params": ["' . $txid . '"]}');
	if (!$response || (is_object ($response) && $response->error)) {
		tech_log (['function' => __FUNCTION__, 'response' => $response]);
		return null;
	} else return $response->result;
}