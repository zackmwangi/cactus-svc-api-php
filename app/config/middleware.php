<?php
declare(strict_types=1);

namespace App\Config;

//include(__DIR__ . '/../middleware/authorization/AuthorizationMiddleware.php');
//include(__DIR__ . '/../middleware/authorization/AuthorizationMiddlewareInterface.php');
//include(__DIR__ . '/../settings/SettingsInterface.php');



use App\Settings\SettingsInterface;
use Psr\Container\ContainerInterface;
use DI\ContainerBuilder;

use App\Middleware\Authorization\AuthorizationMiddlewareInterface;
use App\Middleware\Authorization\AuthorizationMiddleware;
use App\Middleware\CustomHeader\CustomHeaderMiddleware;
use App\Middleware\IpGeolocation\IpGeolocationMiddleware;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        IpGeolocationMiddleware::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);
            $ipInfoAccessToken = $settings->get('IpInfoAccessToken');
            return new IpGeolocationMiddleware($ipInfoAccessToken);
        },
        AuthorizationMiddlewareInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);
            $jwtSettings = $settings->get('jwtSettings');
            return new AuthorizationMiddleware($jwtSettings);
        },
        CustomHeaderMiddleware::class => function (ContainerInterface $c) {
            return new CustomHeaderMiddleware();
        },
    ]);
};