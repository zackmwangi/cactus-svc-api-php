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

use App\Middleware\Authorization\OnboardingAuthMiddlewareInterface;
use App\Middleware\Authorization\OnboardingAuthMiddleware;

use App\Middleware\CustomHeader\CustomHeaderMiddleware;
use App\Middleware\IpGeolocation\IpGeolocationMiddleware;
use App\Middleware\RequestFilter\RequestFilterMiddleware;



return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        RequestFilterMiddleware::class => function (ContainerInterface $c) {
            return new RequestFilterMiddleware();
        },
        IpGeolocationMiddleware::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);
            $ipInfoAccessToken = $settings->get('IpInfoAccessToken');
            return new IpGeolocationMiddleware($ipInfoAccessToken);
        },
        OnboardingAuthMiddleware::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);
            $jwtSettings = $settings->get('jwtSettings');
            return new OnboardingAuthMiddleware($jwtSettings);
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