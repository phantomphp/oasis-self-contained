<?php
define('ROOT', dirname(__DIR__));
ini_set('display_errors', 1);

$autoloader = require_once ROOT . '/vendor/autoload.php';
require_once ROOT . '/app/app.php';
require_once ROOT . '/config/config.php';
require_once ROOT . '/app/controllers.php';

$app->run();