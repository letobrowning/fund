<?php

### Модуль безопасности ###

define ('IV', 'WnRmNDxNnKMcK5j9');	# initialization vector

function security_method () {
	return base64_decode ('YWVzLTI1Ni1jYmM=');
}

function security_check_method () {
	return in_array (security_method (), openssl_get_cipher_methods ());
}

function security_get_master_key () {
	$security_config = [
		'key' => 'hueXRjdDcAjdvcmWj8AeCVHsSuqqJs88dkUVTqUQTvpCQZFynsUzUQ4jRY6wW9AcdbUk6eNnFSqS6NDuMKxqHthxxZ7MU7rBt79Qt4Ja5dWTZ5Mc452m6jRXK9VmL7YFDjBKm3W7aKt5MqjqaVGBAAg8rDkKQnD5u4yySt8t2jhhrJ2SfcJ5D7SyaSs2PuDtWbcgdbK7qBUvMmNTPzV9TVDkvLLu7CMWyx8UKuAYvF88ryVXverp59QmaJnX6gN7',
		'secret' => 'rNcMk2VMK6vMX7dfGNBjpt65uUNvbFpsJQYkXMjrdA52BvLkS6M2RjYrvv9CeE9PFhuW96NAtFuhubuBHArJuyv8ur49Zj5SUBcfThrVqsMDCt7MsyFcgtBbWfx6NZZgzZQCXtbrjnq53B4ztQ3Td29fcf7NCuWeEjBFPVsn4uSPgKdNjfEGn9As4J8n2G6bJE8n2yVT4h4yMdfxz5M85WFMRpnrwY7mBwSYFr4pRJuppT7ffjm7XPwctts7qLN6'
	];
	if (security_check_method ()) {
		return openssl_encrypt ($security_config['key'], security_method (), $security_config['secret'], OPENSSL_RAW_DATA, IV);
	} else return ERROR_SECURITY_ERROR;
}

function security_encrypt ($string) {
	return openssl_encrypt ($string, security_method (), security_get_master_key (), null, IV);
}

function security_decrypt ($string) {
	return openssl_decrypt ($string, security_method (), security_get_master_key (), null, IV);
}