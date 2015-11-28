<?php

$config = [
		"database" => [
			"hostname" => env('DB_HOST'),
			"username" => env('DB_USER'),
			"password" => env('DB_PASS'),
			"dbname" => env('DB_NAME'),
		],
		
		"smtp" => [
			"host" => env('SMTP_HOST'),
			"port" => env('SMTP_PORT', 465),
			"security" => env('SMTP_SECURITY', 'ssl'),
			"uname" => env('SMTP_USER'),
			"pass" => env('SMTP_PASS'),
			"from" => env('SMTP_FROM'),
			"from_name" => env('SMTP_FROM_NAME')
		],
		
		"date" => [
			"timezone" => env('TIMEZONE', "Africa/Nairobi")
		]
];
