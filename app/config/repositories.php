<?php
declare(strict_types=1);

namespace App\Config;

include(__DIR__ . '/../settings/SettingsInterface.php');
include(__DIR__ . '/../repository/authorization/AuthorizationRepositoryInterface.php');

use App\Settings\SettingsInterface;
use App\Repository\Authorization\AuthorizationRepository;

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
            }

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