<?php

use App\middlewares\CorsMiddleware;
use Slim\App;

return function (App $app) {
    $settings = $app->getContainer()->get('settings');

    $app->addMiddleware(new CorsMiddleware());

    $app->addBodyParsingMiddleware();

    $app->addErrorMiddleware(
        $settings['displayErrorDetails'],
        $settings['logErrors'],
        $settings['logErrorDetails']
    );
};