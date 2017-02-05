<?php

namespace Sher\Oasis\Silex\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Sher\Oasis\Silex\Service\StaticUrlGeneratorService;

class StaticUrlGeneratorServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['static_url'] = $app->share(function ($app) {
            $config = $app['static_url.options'];
            return new StaticUrlGeneratorService($config['baseurl'], $config['lang']);
        });
    }

    public function boot(Application $app)
    {
    }
}
