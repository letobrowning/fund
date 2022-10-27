<?php

### Мониторинг здоровья системы, не отвалился ли демон и все в таком роде ###

function sys_check () {
	global $config;
	$functions = ['sys_bitcoind_status', 'sys_free_space', 'sys_detect_overload', 'sys_mongo_status'];
	$file = "/tmp/sys_check";

	if (file_exists ($file) && filesize ($file) && time () - filemtime ($file) <= $config['sys']['check_timeout_min'] * 60 && file_get_contents ($file)) return true;

	$status = [];
	$state = true;
	foreach ($functions as $function) {
		$s = $function ();
		$status[$function] = $s;
		if (!$s) $state = false;
	}

	file_put_contents ($file, $state ? 1 : 0);

	if (!$state) critical_error (['function' => __FUNCTION__, 'cause' => $status]);
}

function sys_bitcoind_status () {
	$block_count = btc_getblockcount ();
	$be_json = @json_decode (file_get_contents ('https://blockexplorer.com/api/status?q=getBlockCount'));
	if (!$be_json) return false;
	if (!$be_json->info->blocks || !$block_count) return false;
	if ($be_json->info->blocks != $block_count) return false;
	return true;
}

function sys_free_space () {
	$out = shell_exec ('df -h');
	$out = explode ("\n", $out);
	foreach ($out as $line) {
		$line = trim ($line);
		$line = preg_replace ("/[ \t]+/", ' ', $line);
		$line = explode (' ', $line);
		if ($line[5] == '/') {
			$use = (float) str_replace ('%', '', $line[4]);
			if ($use >= 90) {
				return false;
			} else return true;
		}
	}
	return false;
}

function sys_detect_overload () {
	$out = explode ("\n", shell_exec ('free -m'));
	$out = explode (' ', preg_replace ("/[ \t]+/", ' ', $out[1]));
	$use_mem = ((float) $out[6]) / ((float) $out[1]);
	return $use_mem >= 0.1;
}

function sys_mongo_status () {
	return strpos (shell_exec ('service mongod status'), 'Active: active (running)') !== false;
}