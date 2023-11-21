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
#
use App\Controllers\Onboarding\OnboardingControllerInterface;
use App\Controllers\Onboarding\OnboardingController;
use App\Repository\Onboarding\OnboardingRepositoryInterface;
#
//
use App\Controllers\Profile\ProfileControllerInterface;
use App\Controllers\Profile\ProfileController;

#
#use App\Controllers\Guardian\GuardianControllerInterface;
#use App\Controllers\Guardian\GuardianController;
//

//
use App\Controllers\Activity\OfferingControllerInterface;
use App\Controllers\Activity\OfferingController;

use App\Controllers\Feed\FeedControllerInterface;
use App\Controllers\Feed\FeedController;

use App\Controllers\Bucketlist\BucketlistControllerInterface;
use App\Controllers\Bucketlist\BucketlistController;

use App\Controllers\Shop\ShopControllerInterface;
use App\Controllers\Shop\ShopController;

use App\Controllers\Messaging\MessagingControllerInterface;
use App\Controllers\Messaging\MessagingController;

use App\Controllers\Notifications\NotificationsControllerInterface;
use App\Controllers\Notifications\NotificationsController;

//
use App\Controllers\Streaming\StreamingControllerInterface;
use App\Controllers\Streaming\StreamingController;
#use App\Repository\Streaming\StreamingRepositoryInterface;
//
use App\Controllers\Healthz\HealthzControllerInterface;
use App\Controllers\Healthz\HealthzController;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([

        //Authorization
        //##################
        //
        AuthorizationControllerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);
            $jwtSettings = $settings->get('jwtSettings');
            $authorizationRepository = $c->get(AuthorizationRepositoryInterface::class);
            return new AuthorizationController($jwtSettings, $authorizationRepository);
        },
        //Onboarding
        //##################
        //
        OnboardingControllerInterface::class => function (ContainerInterface $c) {
            //$settings = $c->get(SettingsInterface::class);
            //$onboardingRepository = $c->get(OnboardingRepositoryInterface::class);
            return new OnboardingController();
        },
        //
        //Profile
        //##################
        //
        ProfileControllerInterface::class => function (ContainerInterface $c) {
           
            return new ProfileController();
        },
        //##################
        //Activity Center
        //
        //##
        //Offering
        OfferingControllerInterface::class => function (ContainerInterface $c) {
           
            return new OfferingController();
        },
        //##
        //Provider

        //##################
        //Bucketlist
        //
        BucketlistControllerInterface::class => function (ContainerInterface $c) {
           
            return new BucketlistController();
        },
        //##################
        //Feed
        //
        FeedControllerInterface::class => function (ContainerInterface $c) {
           
            return new FeedController();
        },
        //##################
        //Shop
        //
        ShopControllerInterface::class => function (ContainerInterface $c) {
           
            return new ShopController();
        },
        //##################
        //Messaging
        //
        MessagingControllerInterface::class => function (ContainerInterface $c) {
           
            return new MessagingController();
        },
        //##################
        //Notifications
        //
        NotificationsControllerInterface::class => function (ContainerInterface $c) {
           
            return new NotificationsController();
        },
        //##################
        //Streaming
        //
        StreamingControllerInterface::class => function (ContainerInterface $c) {
            //$settings = $c->get(SettingsInterface::class);
            return new StreamingController();
        },
        //##################
        //Healthz
        //
        HealthzControllerInterface::class => function (ContainerInterface $c) {
            //$settings = $c->get(SettingsInterface::class);
            return new HealthzController();
        },
        //##################

    ]);
};