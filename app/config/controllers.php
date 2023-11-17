<?php
declare(strict_types=1);

namespace App\Config;

//include(__DIR__ . '/../controllers/authorization/AuthorizationController.php');
//include(__DIR__ . '/../controllers/authorization/AuthorizationControllerInterface.php');
//
//include(__DIR__ . '/../controllers/guardian/GuardianController.php');
//include(__DIR__ . '/../controllers/guardian/GuardianControllerInterface.php');

use App\Settings\SettingsInterface;
use Psr\Container\ContainerInterface;
use DI\ContainerBuilder;

use App\Controllers\Authorization\AuthorizationControllerInterface;
use App\Controllers\Authorization\AuthorizationController;
use App\Repository\Authorization\AuthorizationRepositoryInterface;

use App\Controllers\Guardian\GuardianControllerInterface;
use App\Controllers\Guardian\GuardianController;
use App\Controllers\Onboarding\OnboardingController;
//
/*
use Agence104\Livekit;
use Agence104\Livekit\AccessTokenOptions;
use Agence104\Livekit\AccessToken;
use Agence104\Livekit\VideoGrant;
*/
//
use App\Controllers\Streaming\StreamingControllerInterface;
use App\Controllers\Streaming\StreamingController;
use App\Repository\Streaming\StreamingRepositoryInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([

        //AuthorizationController::class => function (ContainerInterface $c) {
        AuthorizationControllerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);
            $jwtSettings = $settings->get('jwtSettings');
            $authorizationRepository = $c->get(AuthorizationRepositoryInterface::class);
            return new AuthorizationController($jwtSettings, $authorizationRepository);
        },
        OnboardingControllerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);
            //$jwtSettings = $settings->get('jwtSettings');
            //$authorizationRepository = $c->get(AuthorizationRepositoryInterface::class);
            return new OnboardingController();
        },

        //
        //Streaming
        //
        /*
        StreamingControllerInterface ::class => function (ContainerInterface $c) {
            //$liveStreamingSettings  = $c->get(SettingsInterface::class)->get('streamingLivekitSettings');
            $StreamingRepository = $c->get(StreamingRepositoryInterface::class);
            return new StreamingController($StreamingRepository);

        },
        */
        //
        //Guardian
        /*
        GuardianControllerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);
            $db = $settings->get('dbSettings');
            return new GuardianController($db);
        },
        */

    ]);
};