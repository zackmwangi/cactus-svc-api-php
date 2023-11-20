<?php
declare(strict_types=1);

namespace App\Config;
//
//----------------------------------------------------------------

//----------------------------------------------------------------
//
//
use App\Settings\SettingsInterface;
//
use App\Repository\Authorization\AuthorizationRepositoryInterface;
use App\Repository\Authorization\AuthorizationRepository;
//
//###########################
//
use App\Repository\Activity\Core\ActivityRepositoryInterface;
use App\Repository\Activity\Core\ActivityRepository;

use App\Repository\Activity\Core\SupercategoryRepositoryInterface;
use App\Repository\Activity\Core\SupercategoryRepository;

use App\Repository\Activity\Core\CategoryRepositoryInterface;
use App\Repository\Activity\Core\CategoryRepository;

use App\Repository\Activity\Core\SubcategoryRepositoryInterface;
use App\Repository\Activity\Core\SubcategoryRepository;
//
//###########################
//

use App\Repository\Onboarding\OnboardingRepositoryInterface;
use App\Repository\Onboarding\OnboardingRepository;

use App\Repository\Onboarding\Registrant\RegistrantRepositoryInterface;
use App\Repository\Onboarding\Registrant\RegistrantRepository;
/*
use App\Repository\Onboarding\Registrant\RegistrantGoogleRepositoryInterface;
use App\Repository\Onboarding\Registrant\RegistrantGoogleRepository;

use App\Repository\Onboarding\Registrant\RegistrantAppleRepositoryInterface;
use App\Repository\Onboarding\Registrant\RegistrantAppleRepository;
*/
use App\Repository\Onboarding\Options\OnboardingOptionsRepositoryInterface;
use App\Repository\Onboarding\Options\OnboardingOptionsRepository;
//
//###########################
//
use App\Repository\Activity\Participation\ParticipationRepositoryInterface;
use App\Repository\Activity\Participation\ParticipationRepository;

use App\Repository\Activity\Participation\ParticipationHistoryRepositoryInterface;
use App\Repository\Activity\Participation\ParticipationHistoryRepository;


use App\Repository\Activity\Post\PostRepositoryInterface;
use App\Repository\Activity\Post\PostRepository;
//
//
//####
//
use App\Repository\Activity\Productivity\Calendar\CalendarRepositoryInterface;
use App\Repository\Activity\Productivity\Calendar\CalendarRepository;

use App\Repository\Activity\Productivity\Goal\GoalRepositoryInterface;
use App\Repository\Activity\Productivity\Goal\GoalRepository;

use App\Repository\Activity\Productivity\Streak\StreakRepositoryInterface;
use App\Repository\Activity\Productivity\Streak\StreakRepository;

//
//###########################
//
//use App\Repository\Streaming\StreamingRepositoryInterface;
//use App\Repository\Streaming\StreamingRepository;

use PDO;

use Psr\Container\ContainerInterface;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder){

    

    $containerBuilder->addDefinitions([
        //
        //Authorization
            //badlist
            //whitelist
            //guardians
            //guardians_waitlist
        AuthorizationRepositoryInterface::class => function (ContainerInterface $c) {
            $dbConnection = $c->get(SettingsInterface::class)->get('dbSettings')['dbConnection'];
            $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //
            //$authProvider = "google";
            return new AuthorizationRepository(
                $dbConnection,
                //$authProvider,
            );
            
        },
        //
        //###############
        // Activities Core
        /*
        ActivityRepositoryInterface::class => function (ContainerInterface $c) {
            $dbConnection = $c->get(SettingsInterface::class)->get('dbSettings')['dbConnection'];
            $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return new ActivityRepository($dbConnection);
        },
        SupercategoryRepositoryInterface::class => function (ContainerInterface $c) {
            $dbConnection = $c->get(SettingsInterface::class)->get('dbSettings')['dbConnection'];
            $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return new SupercategoryRepository($dbConnection);
        },
        CategoryRepositoryInterface::class => function (ContainerInterface $c) {
            $dbConnection = $c->get(SettingsInterface::class)->get('dbSettings')['dbConnection'];
            $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return new CategoryRepository($dbConnection);
        },
        SubcategoryRepositoryInterface::class => function (ContainerInterface $c) {
            $dbConnection = $c->get(SettingsInterface::class)->get('dbSettings')['dbConnection'];
            $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return new SubcategoryRepository($dbConnection);
        },
        */
        //
        //###############
        //
        OnboardingRepositoryInterface::class => function (ContainerInterface $c) {
            $dbConnection = $c->get(SettingsInterface::class)->get('dbSettings')['dbConnection'];
            $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return new OnboardingRepository($dbConnection);
        },

        RegistrantRepositoryInterface::class => function (ContainerInterface $c) {
            $dbConnection = $c->get(SettingsInterface::class)->get('dbSettings')['dbConnection'];
            $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return new RegistrantRepository($dbConnection);
        },
        /*
        RegistrantGoogleRepositoryInterface::class => function (ContainerInterface $c) {
            $dbConnection = $c->get(SettingsInterface::class)->get('dbSettings')['dbConnection'];
            $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return new RegistrantGoogleRepository($dbConnection);
        },
        RegistrantGoogleRepositoryInterface::class => function (ContainerInterface $c) {
            $dbConnection = $c->get(SettingsInterface::class)->get('dbSettings')['dbConnection'];
            $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return new RegistrantGoogleRepository($dbConnection);
        },
        */
        OnboardingOptionsRepositoryInterface::class => function (ContainerInterface $c) {
            $dbConnection = $c->get(SettingsInterface::class)->get('dbSettings')['dbConnection'];
            $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return new OnboardingOptionsRepository($dbConnection);
        },
        //###############

        //###############
            //
        //Streaming
        /*
        StreamingRepositoryInterface::class => function (ContainerInterface $c) {
                
            $liveStreamingSettings  = $c->get(SettingsInterface::class)->get('streamingLivekitSettings');
            return new StreamingRepository($liveStreamingSettings);
        }
        */
        //
        //Guardian
            //guardians
            //dependants
            //guardian_dependant_join

        //Dependant
            //dependants
            //guardians
            //dependant_guardian_join

        //Interests

        //Providers
            //Users
            //Orgs
            //Brands

        //Activity_offerings
            //Home
            //Pro

        //Activity_performance
            //Goals
            //Streaks
            //Stats

        //Feed

        //Bucketlist

        //Shop

        //Profile

        //Messaging

        //Notifications
        //

        //Co-guardianship


    ]);
};