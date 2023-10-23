<?php
declare(strict_types=1);

namespace App\Config;

include(__DIR__ . '/../middleware/authorization/AuthorizationMiddleware.php');
include(__DIR__ . '/../middleware/authorization/AuthorizationMiddlewareInterface.php');
include(__DIR__ . '/../settings/SettingsInterface.php');



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