<?php
require_once ROOT . '/vendor/autoload.php';

$app = new Silex\Application();
$app->register(new Silex\Provider\DoctrineServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider());
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Sher\Oasis\Silex\Provider\StaticUrlGeneratorServiceProvider());
