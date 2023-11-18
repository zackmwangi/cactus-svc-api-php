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

use App\Repository\Onboarding\Registrant\OnboardingRegistrantRepositoryInterface;
use App\Repository\Onboarding\Registrant\OnboardingRegistrantRepository;

use App\Repository\Onboarding\Options\OnboardingOptionsRepositoryInterface;
use App\Repository\Onboarding\Options\OnboardingOptionsRepository;

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
            return new AuthorizationRepository($dbConnection);
            
        },
        //###############
        OnboardingRegistrantRepositoryInterface::class => function (ContainerInterface $c) {
            $dbConnection = $c->get(SettingsInterface::class)->get('dbSettings')['dbConnection'];
            $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return new OnboardingRegistrantRepository($dbConnection);
            
        },
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