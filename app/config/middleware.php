<?php
declare(strict_types=1);

use App\Settings\SettingsInterface;
use Psr\Container\ContainerInterface;
use DI\ContainerBuilder;

use App\Middleware\Authorization\AuthorizationMiddleware;
use App\Middleware\Authorization\AuthorizationMiddlewareInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        AuthorizationMiddlewareInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);
            $jwtSettings = $settings->get('jwtSettings');
            return new AuthorizationMiddleware($jwtSettings);
        },
    ]);
};