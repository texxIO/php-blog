<?php
declare(strict_types = 1);
// To help the built-in PHP dev server, check if the request was actually for
// something which should probably be served as a static file
if (PHP_SAPI === 'cli-server' && $_SERVER['SCRIPT_FILENAME'] !== __FILE__) {
    return false;
}


$app = require __DIR__ . '/../config/bootstrap.php';
// Initialize application

//var_dump($app->run());
