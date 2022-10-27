<?php

### Модуль логгирования и контроля ошибок ###
function tech_log ($info) {
	global $config;
	if (!isset ($config['log']['dir']) || !$config['log']['dir'] || !file_exists ($config['log']['dir'])) die ('log dir does not exist');
	$list = scandir ($config['log']['dir']);
	$last = count ($list) - 3;
	$log_file = "{$config['log']['dir']}/{$last}.log";
	if (file_exists ($log_file) && filesize ($log_file) >= $config['log']['max_size_mb'] * 1024 * 1024) {
		$last ++ ;
		$log_file = "{$config['log']['dir']}/{$last}.log";
	}
	file_put_contents ($log_file, date ('Y-m-d H:i:s') . ' :: ' . json_encode ($info) . "\n", FILE_APPEND);
}

function critical_error ($info) {
	tech_log ([
		'error' => 'critical',
		'info' => $info
	]);
	die (json_encode (['error' => 'critical', 'info' => $info]));
}