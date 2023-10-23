<?php
declare(strict_types=1);

//include(__DIR__ . '/../settings/SettingsInterface.php');

namespace App\Config;

use App\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
    ]);
};



















/*

//require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../app/config/database.php'; // Database configuration
require __DIR__ . '/../../app/config/jwt.php';

use DI\Container as xContainer;
use Psr\Container\ContainerInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

use Slim\Routing\RouteCollectorProxy;
use Slim\Factory\AppFactory as xAppFactory;

$container = new xContainer();
//
//##################################################
$container->set('JWT_KEY','secret_key');
//#################
$container->set('AuthorizationController',function (ContainerInterface $container) {

});



//##################################################
//
xAppFactory::setContainer($container);

$app = xAppFactory::create();
$app->addRoutingMiddleware();

$logger = new Logger('cactus.nacha.life');
$streamHandler = new StreamHandler(__DIR__ . '/../logs/cactus.log', 100);
$logger->pushHandler($streamHandler);
$errorMiddleware = $app->addErrorMiddleware(false, true, true,$logger);

$errorHandler = $errorMiddleware->getDefaultErrorHandler();
$errorHandler->forceContentType('application/json');
*/
######################################################












