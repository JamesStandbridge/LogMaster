<?php

require 'vendor/autoload.php';



use LogMaster\LogUtils\LogManager;

$manager = new LogManager(__DIR__."/logs");

$nameBuilder = [
	[
		"type" => "text",
		"value" => "logs"
	],
	[
		"type" => "date"
	]
];

$params = [
	[
		"type" => "file_write_life_time",
		"value" => 1
	]
];

$manager->new("errors", $params, $nameBuilder, "errors");

$manager->write_log("errors", "contenu du message");




