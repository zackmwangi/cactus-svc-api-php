<?php
declare(strict_types=1);
//
date_default_timezone_set('UTC');
//
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//
require __DIR__ . '/../vendor/autoload.php';
//
include(__DIR__ . '/../app/settings/SettingsInterface.php');
include(__DIR__ . '/../app/settings/Settings.php');
//
include(__DIR__ . '/../app/repository/authorization/AuthorizationRepositoryInterface.php');
include(__DIR__ . '/../app/repository/authorization/AuthorizationRepository.php');
//
include(__DIR__ . '/../app/repository/onboarding/registrant/RegistrantRepositoryInterface.php');
include(__DIR__ . '/../app/repository/onboarding/registrant/RegistrantRepository.php');
//
include(__DIR__ . '/../app/repository/onboarding/options/OptionsRepositoryInterface.php');
include(__DIR__ . '/../app/repository/onboarding/options/OptionsRepository.php');
//
include(__DIR__ . '/../app/repository/streaming/StreamingRepositoryInterface.php');
include(__DIR__ . '/../app/repository/streaming/StreamingRepository.php');
//
include(__DIR__ . '/../app/middleware/requestfilter/RequestFilterMiddlewareInterface.php');
include(__DIR__ . '/../app/middleware/requestfilter/RequestFilterMiddleware.php');
//
include(__DIR__ . '/../app/middleware/customheader/CustomHeaderMiddlewareInterface.php');
include(__DIR__ . '/../app/middleware/customheader/CustomHeaderMiddleware.php');
//
include(__DIR__ . '/../app/middleware/ipgeolocation/IpGeolocationMiddlewareInterface.php');
include(__DIR__ . '/../app/middleware/ipgeolocation/IpGeolocationMiddleware.php');
//
include(__DIR__ . '/../app/middleware/authorization/OnboardingAuthMiddlewareInterface.php');
include(__DIR__ . '/../app/middleware/authorization/OnboardingAuthMiddleware.php');
//
include(__DIR__ . '/../app/middleware/authorization/AuthorizationMiddlewareInterface.php');
include(__DIR__ . '/../app/middleware/authorization/AuthorizationMiddleware.php');
//
include(__DIR__ . '/../app/controllers/authorization/AuthorizationControllerInterface.php');
include(__DIR__ . '/../app/controllers/authorization/AuthorizationController.php');
//
include(__DIR__ . '/../app/controllers/onboarding/OnboardingControllerInterface.php');
include(__DIR__ . '/../app/controllers/onboarding/OnboardingController.php');
//
include(__DIR__ . '/../app/controllers/streaming/StreamingControllerInterface.php');
include(__DIR__ . '/../app/controllers/streaming/StreamingController.php');
//
include(__DIR__ . '/../app/controllers/guardian/GuardianControllerInterface.php');
include(__DIR__ . '/../app/controllers/guardian/GuardianController.php');
//
//
//use App\Settings\Settings;
use App\Settings\SettingsInterface;

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
//use Slim\Handlers\ErrorHandler;
use Psr\Log\LoggerInterface;

$containerBuilder = new ContainerBuilder();

// Should be set to true in production
//if (false) { 
	//$containerBuilder->enableCompilation(__DIR__ . '/../var/cache');
//}

//#############################
// Set up settings
//$settingsClass = require __DIR__ . '/../app/settings/Settings.php';
$settings = require __DIR__ . '/../app/config/settings.php';
$settings($containerBuilder);



// Set up Dependencies
$dependencies = require __DIR__ . '/../app/config/dependencies.php'; 
$dependencies($containerBuilder);

// Tweak DB connection config
//$dbConnection = $settings->get(SettingsInterface::class)->get('dbSettings')['dbConnection'];
//$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//
// Register  Repositories
$repositories = require __DIR__ . '/../app/config/repositories.php';
$repositories($containerBuilder);

// Register Controllers
$controllers = require __DIR__ . '/../app/config/controllers.php';
$controllers($containerBuilder);

// Register Middleware
$middleware = require __DIR__ . '/../app/config/middleware.php';
$middleware($containerBuilder);

// Build ALL PHP-DI Container instance
$container = $containerBuilder->build();

/** @var SettingsInterface $settings */
$settings = $container->get(SettingsInterface::class);

AppFactory::setContainer($container);
$app = AppFactory::create();

// Register middleware
$app->addRoutingMiddleware();

//Response control - errors
$displayErrorDetails = $settings->get('displayErrorDetails');
$logError = $settings->get('logError');
$logErrorDetails = $settings->get('logErrorDetails');
$loggerClass = $container->get(LoggerInterface::class);
$errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, $logError, $logErrorDetails,$loggerClass);

//Response control - content type
$errorHandler = $errorMiddleware->getDefaultErrorHandler();
$errorHandler->forceContentType('application/json');

// Register Routes
//$app->add($app->getContainer()->get(IpGeolocationMiddlewareInterface::class));
//require __DIR__ . '/../app/routes/api.php'; 
$routes = require __DIR__ . '/../app/routes/api.php';
$routes($app, $container);

//##############################
$app->run();



