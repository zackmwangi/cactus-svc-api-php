<?php
declare(strict_types=1);

namespace App\Config;

use App\Settings\SettingsInterface;
use App\Settings\Settings;

use DI\ContainerBuilder;
use Monolog\Logger;
use Dotenv\Dotenv;
use PDO;

return function (ContainerBuilder $containerBuilder) {

    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    // Global Settings Object
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function (){
            return new Settings([
                'displayErrorDetails' => true, // Should be set to false in production
                'logError'            => true,
                'logErrorDetails'     => true,
                'logger' => [
                    'name' => $_ENV['LOGGER_NAME'],
                    'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../../logs/cactus.log',
                    'level' => Logger::DEBUG,
                ],

                //JWT
                'jwtSettings' => [
                    'secret_key' => $_ENV['JWT_SECRET_KEY'],    // Replace with your own secret key
                    'algorithm' =>  $_ENV['JWT_ALGORITHM'],              // JWT algorithm (e.g., HS256)
                    'valid_for' => intval($_ENV['JWT_VALID_FOR_SEC']),
                    'jwtAud' => $_ENV['JWT_AUD'],
                    'jwtIss' => $_ENV['JWT_ISS'],
                    'jwtFirebaseProjectId'=>$_ENV['JWT_FIREBASE_PROJ_ID'],
                ],
                //DB
                'dbSettings' => [
                    'dbConnection' => new PDO("mysql:host=".$_ENV['DB_HOST'].";dbname=".$_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASS']),
                ],
                //GeoLocation
                'IpInfoAccessToken' => $_ENV['IP_INFO_ACCESS_TOKEN'],
                //
                //Streaming
                'streamingLivekitSettings' => [
                    'lkHost'=>$_ENV['LIVEKIT_API_HOST'],
                    'lkApiKey'=> $_ENV['LIVEKIT_API_KEY'],
                    'lkApiSecret'=>$_ENV['LIVEKIT_API_SECRET'],

                ],

            ]);
        },


    ]);
};

//LOGGER

//Content