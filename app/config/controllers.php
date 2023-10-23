<?php
declare(strict_types=1);

//include(__DIR__ . '/../controllers/authorization/AuthorizationController.php');
//include(__DIR__ . '/../controllers/authorization/AuthorizationControllerInterface.php');
//
//include(__DIR__ . '/../controllers/guardian/GuardianController.php');
//include(__DIR__ . '/../controllers/guardian/GuardianControllerInterface.php');

namespace App\Config;

use App\Settings\SettingsInterface;
use Psr\Container\ContainerInterface;
use DI\ContainerBuilder;

use App\Controllers\Authorization\AuthorizationController;
use App\Controllers\Authorization\AuthorizationControllerInterface;

use App\Controllers\Guardian\GuardianController;
use App\Controllers\Guardian\GuardianControllerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([

        //AuthorizationController::class => function (ContainerInterface $c) {
        AuthorizationControllerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);
            $jwtSettings = $settings->get('jwtSettings');
            $authorizationRepository = $c->get(AuthorizationRepositoryInterface::class);
            return new AuthorizationController($jwtSettings, $authorizationRepository);
        },
        //Guardian
        GuardianControllerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);
            $db = $settings->get('dbSettings');
            return new GuardianController($db);
        },

    ]);
};