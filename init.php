<?php

# Основные настройки
include_once ($basedir . '/vendor/autoload.php');
$client = new MongoDB\Client('mongodb://127.0.0.1:27017');

$config = [
	'btc' => [
		'host' => '127.0.0.1',
		'port' => '8332'
	],
	'log' => [
		'max_size_mb' => 10,
		'dir' => '/var/log/fund'	# mkdir & chmod required
	],
	'sys' => [
		'check_timeout_min' => 5
	],
	'admin' => [
		'user' => 'AERd7twU7USQzrtE',
		'pass' => 'rqYKd3BDxhcCgA4e',
	]
];