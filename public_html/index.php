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
//
//
//Repo
//
include(__DIR__ . '/../app/repository/activity/core/ActivityRepositoryInterface.php');
include(__DIR__ . '/../app/repository/activity/core/ActivityRepository.php');

include(__DIR__ . '/../app/repository/activity/core/CategoryRepositoryInterface.php');
include(__DIR__ . '/../app/repository/activity/core/CategoryRepository.php');

include(__DIR__ . '/../app/repository/activity/core/SupercategoryRepositoryInterface.php');
include(__DIR__ . '/../app/repository/activity/core/SupercategoryRepository.php');

include(__DIR__ . '/../app/repository/activity/core/SubcategoryRepositoryInterface.php');
include(__DIR__ . '/../app/repository/activity/core/SubcategoryRepository.php');
//
include(__DIR__ . '/../app/repository/activity/participation/ParticipationRepositoryInterface.php');
include(__DIR__ . '/../app/repository/activity/participation/ParticipationRepository.php');

include(__DIR__ . '/../app/repository/activity/participation/ParticipationHistoryRepositoryInterface.php');
include(__DIR__ . '/../app/repository/activity/participation/ParticipationHistoryRepository.php');

include(__DIR__ . '/../app/repository/activity/post/PostRepositoryInterface.php');
include(__DIR__ . '/../app/repository/activity/post/PostRepository.php');
//
include(__DIR__ . '/../app/repository/activity/productivity/calendar/CalendarRepositoryInterface.php');
include(__DIR__ . '/../app/repository/activity/productivity/calendar/CalendarRepository.php');

include(__DIR__ . '/../app/repository/activity/productivity/goal/GoalRepositoryInterface.php');
include(__DIR__ . '/../app/repository/activity/productivity/goal/GoalRepository.php');

include(__DIR__ . '/../app/repository/activity/productivity/streak/StreakRepositoryInterface.php');
include(__DIR__ . '/../app/repository/activity/productivity/streak/StreakRepository.php');

include(__DIR__ . '/../app/repository/activity/reward/RewardRepositoryInterface.php');
include(__DIR__ . '/../app/repository/activity/reward/RewardRepository.php');
//
include(__DIR__ . '/../app/repository/accessibility/AccessibilityRepositoryInterface.php');
include(__DIR__ . '/../app/repository/accessibility/AccessibilityRepository.php');
//
include(__DIR__ . '/../app/repository/authorization/AuthorizationRepositoryInterface.php');
include(__DIR__ . '/../app/repository/authorization/AuthorizationRepository.php');

include(__DIR__ . '/../app/repository/bucketlist/BucketlistRepositoryInterface.php');
include(__DIR__ . '/../app/repository/bucketlist/BucketlistRepository.php');

include(__DIR__ . '/../app/repository/feed/FeedRepositoryInterface.php');
include(__DIR__ . '/../app/repository/feed/FeedRepository.php');

include(__DIR__ . '/../app/repository/feed/post/PostRepositoryInterface.php');
include(__DIR__ . '/../app/repository/feed/post/PostRepository.php');

include(__DIR__ . '/../app/repository/messaging/MessagingRepositoryInterface.php');
include(__DIR__ . '/../app/repository/messaging/MessagingRepository.php');

include(__DIR__ . '/../app/repository/notifications/NotificationsRepositoryInterface.php');
include(__DIR__ . '/../app/repository/notifications/NotificationsRepository.php');

include(__DIR__ . '/../app/repository/onboarding/options/OnboardingOptionsRepositoryInterface.php');
include(__DIR__ . '/../app/repository/onboarding/options/OnboardingOptionsRepository.php');

include(__DIR__ . '/../app/repository/onboarding/registrant/RegistrantProviderRepositoryInterface.php');
//
include(__DIR__ . '/../app/repository/onboarding/registrant/RegistrantGoogleRepositoryInterface.php');
include(__DIR__ . '/../app/repository/onboarding/registrant/RegistrantGoogleRepository.php');
//
include(__DIR__ . '/../app/repository/onboarding/registrant/RegistrantAppleRepositoryInterface.php');
include(__DIR__ . '/../app/repository/onboarding/registrant/RegistrantAppleRepository.php');
//
include(__DIR__ . '/../app/repository/profile/authprofile/AuthprofileProviderRepositoryInterface.php');

include(__DIR__ . '/../app/repository/profile/authprofile/AuthprofileGoogleRepositoryInterface.php');
include(__DIR__ . '/../app/repository/profile/authprofile/AuthprofileGoogleRepository.php');

include(__DIR__ . '/../app/repository/profile/authprofile/AuthprofileAppleRepositoryInterface.php');
include(__DIR__ . '/../app/repository/profile/authprofile/AuthprofileAppleRepository.php');

include(__DIR__ . '/../app/repository/profile/dependant/DependantRepositoryInterface.php');
include(__DIR__ . '/../app/repository/profile/dependant/DependantRepository.php');

include(__DIR__ . '/../app/repository/profile/devices/DevicesRepositoryInterface.php');
include(__DIR__ . '/../app/repository/profile/devices/DevicesRepository.php');

include(__DIR__ . '/../app/repository/profile/guardian/GuardianRepositoryInterface.php');
include(__DIR__ . '/../app/repository/profile/guardian/GuardianRepository.php');

include(__DIR__ . '/../app/repository/profile/identity/IdentityRepositoryInterface.php');
include(__DIR__ . '/../app/repository/profile/identity/IdentityRepository.php');

include(__DIR__ . '/../app/repository/profile/identity/preference/activity/ActivityRepositoryInterface.php');
include(__DIR__ . '/../app/repository/profile/identity/preference/activity/ActivityRepository.php');

include(__DIR__ . '/../app/repository/profile/identity/preference/accessibility/AccessibilityRepositoryInterface.php');
include(__DIR__ . '/../app/repository/profile/identity/preference/accessibility/AccessibilityRepository.php');

include(__DIR__ . '/../app/repository/profile/settings/ProfileSettingsRepositoryInterface.php');
include(__DIR__ . '/../app/repository/profile/settings/ProfileSettingsRepository.php');
//
include(__DIR__ . '/../app/repository/provider/brand/BrandRepositoryInterface.php');
include(__DIR__ . '/../app/repository/provider/brand/BrandRepository.php');

include(__DIR__ . '/../app/repository/provider/brand/flavor/FlavorRepositoryInterface.php');
include(__DIR__ . '/../app/repository/provider/brand/flavor/FlavorRepository.php');
//
#include(__DIR__ . '/../app/repository/provider/dashboard/');
//
include(__DIR__ . '/../app/repository/provider/offering/OfferingRepositoryInterface.php');
include(__DIR__ . '/../app/repository/provider/offering/OfferingRepository.php');

include(__DIR__ . '/../app/repository/provider/offering/history/OfferingHistoryRepositoryInterface.php');
include(__DIR__ . '/../app/repository/provider/offering/history/OfferingHistoryRepository.php');

include(__DIR__ . '/../app/repository/provider/offering/reviews/ReviewRepositoryInterface.php');
include(__DIR__ . '/../app/repository/provider/offering/reviews/ReviewRepository.php');

include(__DIR__ . '/../app/repository/provider/offering/rewards/RewardRepositoryInterface.php');
include(__DIR__ . '/../app/repository/provider/offering/rewards/RewardRepository.php');

include(__DIR__ . '/../app/repository/provider/offering/sponsorship/SponsorRepositoryInterface.php');
include(__DIR__ . '/../app/repository/provider/offering/sponsorship/SponsorRepository.php');

include(__DIR__ . '/../app/repository/provider/profile/ProfileRepositoryInterface.php');
include(__DIR__ . '/../app/repository/provider/profile/ProfileRepository.php');

include(__DIR__ . '/../app/repository/shop/ShopRepositoryInterface.php');
include(__DIR__ . '/../app/repository/shop/ShopRepository.php');

include(__DIR__ . '/../app/repository/shop/brand/BrandRepositoryInterface.php');
include(__DIR__ . '/../app/repository/shop/brand/BrandRepository.php');

include(__DIR__ . '/../app/repository/shop/brand/flavor/FlavorRepositoryInterface.php');
include(__DIR__ . '/../app/repository/shop/brand/flavor/FlavorRepository.php');

include(__DIR__ . '/../app/repository/shop/product/ProductRepositoryInterface.php');
include(__DIR__ . '/../app/repository/shop/product/ProductRepository.php');
//
include(__DIR__ . '/../app/repository/streaming/StreamingRepositoryInterface.php');
include(__DIR__ . '/../app/repository/streaming/StreamingRepository.php');
//
//
//
//Middleware
//
include(__DIR__ . '/../app/middleware/authorization/AuthorizationInitMiddlewareInterface.php');
include(__DIR__ . '/../app/middleware/authorization/AuthorizationInitMiddleware.php');

include(__DIR__ . '/../app/middleware/authorization/AuthorizationMiddlewareInterface.php');
include(__DIR__ . '/../app/middleware/authorization/AuthorizationMiddleware.php');

include(__DIR__ . '/../app/middleware/authorization/OnboardingAuthMiddlewareInterface.php');
include(__DIR__ . '/../app/middleware/authorization/OnboardingAuthMiddleware.php');

include(__DIR__ . '/../app/middleware/customheader/CustomHeaderMiddlewareInterface.php');
include(__DIR__ . '/../app/middleware/customheader/CustomHeaderMiddleware.php');

include(__DIR__ . '/../app/middleware/ipgeolocation/IpGeolocationMiddlewareInterface.php');
include(__DIR__ . '/../app/middleware/ipgeolocation/IpGeolocationMiddleware.php');

include(__DIR__ . '/../app/middleware/requestfilter/RequestFilterMiddlewareInterface.php');
include(__DIR__ . '/../app/middleware/requestfilter/RequestFilterMiddleware.php');
//
//
//
//Util
include(__DIR__ . '/../app/util/JwtHelper.php');
include(__DIR__ . '/../app/util/GenderInferrer.php');
//
//
//
//Controller
include(__DIR__ . '/../app/controllers/activity/OfferingControllerInterface.php');
include(__DIR__ . '/../app/controllers/activity/OfferingController.php');

include(__DIR__ . '/../app/controllers/authorization/AuthorizationControllerInterface.php');
include(__DIR__ . '/../app/controllers/authorization/AuthorizationController.php');

include(__DIR__ . '/../app/controllers/bucketlist/BucketlistControllerInterface.php');
include(__DIR__ . '/../app/controllers/bucketlist/BucketlistController.php');

include(__DIR__ . '/../app/controllers/feed/FeedControllerInterface.php');
include(__DIR__ . '/../app/controllers/feed/FeedController.php');

include(__DIR__ . '/../app/controllers/healthz/HealthzControllerInterface.php');
include(__DIR__ . '/../app/controllers/healthz/HealthzController.php');

include(__DIR__ . '/../app/controllers/messaging/MessagingControllerInterface.php');
include(__DIR__ . '/../app/controllers/messaging/MessagingController.php');

include(__DIR__ . '/../app/controllers/notifications/NotificationsControllerInterface.php');
include(__DIR__ . '/../app/controllers/notifications/NotificationsController.php');

include(__DIR__ . '/../app/controllers/onboarding/OnboardingControllerInterface.php');
include(__DIR__ . '/../app/controllers/onboarding/OnboardingController.php');

include(__DIR__ . '/../app/controllers/profile/ProfileControllerInterface.php');
include(__DIR__ . '/../app/controllers/profile/ProfileController.php');

include(__DIR__ . '/../app/controllers/provider/ProviderControllerInterface.php');
include(__DIR__ . '/../app/controllers/provider/ProviderController.php');

include(__DIR__ . '/../app/controllers/shop/ShopControllerInterface.php');
include(__DIR__ . '/../app/controllers/shop/ShopController.php');

include(__DIR__ . '/../app/controllers/streaming/StreamingControllerInterface.php');
include(__DIR__ . '/../app/controllers/streaming/StreamingController.php');
//
use App\Settings\SettingsInterface;
use App\Settings\Settings;

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
$settings = require __DIR__ . '/../app/config/Settings.php';
$settings($containerBuilder);

// Set up Dependencies
$dependencies = require __DIR__ . '/../app/config/Dependencies.php'; 
$dependencies($containerBuilder);

// Register  Repositories
$repositories = require __DIR__ . '/../app/config/Repositories.php';
$repositories($containerBuilder);

// Register Middleware
$middleware = require __DIR__ . '/../app/config/Middleware.php';
$middleware($containerBuilder);

// Register Controllers
$controllers = require __DIR__ . '/../app/config/Controllers.php';
$controllers($containerBuilder);

//
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
$routes = require __DIR__ . '/../app/routes/api.php';
$routes($app, $container);

//##############################
$app->run();



