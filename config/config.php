<?php

$config = Symfony\Component\Yaml\Yaml::parse(file_get_contents(__DIR__ . '/config.yml'));

$app['static_url.options'] = $config['static_url.options'];

$app['twig.path'] = ROOT . '/views';
if ($config['env'] != 'dev') {
    $app['twig.options'] = array(
        'cache' => ROOT . '/cache/views/en',
    );
}

$app['page'] = $config['page'];
$app['i18n'] = $config['i18n'];
