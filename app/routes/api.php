<?php
declare(strict_types=1);

use App\Controllers\Authorization\AuthorizationControllerInterface;

use App\Controllers\Onboarding\OnboardingControllerInterface;

use App\Controllers\Profile\ProfileControllerInterface;

//use App\Controllers\Guardian\GuardianControllerInterface;
//
use App\Controllers\Activity\OfferingControllerInterface;

use App\Controllers\Feed\FeedControllerInterface;
//
use App\Controllers\Bucketlist\BucketlistControllerInterface;
//
use App\Controllers\Shop\ShopControllerInterface;
//
use App\Controllers\Messaging\MessagingControllerInterface;
//
use App\Controllers\Notifications\NotificationsControllerInterface;

//
use App\Controllers\Streaming\StreamingControllerInterface;
//
use App\Controllers\Healthz\HealthzControllerInterface;
//
//
use App\Middleware\Authorization\AuthorizationInitMiddlewareInterface;
use App\Middleware\Authorization\AuthorizationMiddlewareInterface;
use App\Middleware\Authorization\OnboardingAuthMiddlewareInterface;
use App\Middleware\RequestFilter\RequestFilterMiddleware;
use App\Middleware\CustomHeader\CustomHeaderMiddleware;
use App\Middleware\IpGeolocation\IpGeolocationMiddleware;
//
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy;
use Slim\App;
//use Psr\Container\ContainerInterface;
use DI\Container;
//use DI\ContainerBuilder;

return function (App $app, Container $dependencyContainer) {

    $app->add($app->getContainer()->get(RequestFilterMiddleware::class));
    $app->add($app->getContainer()->get(CustomHeaderMiddleware::class));
    $app->add($app->getContainer()->get(IpGeolocationMiddleware::class));
    //
    //Main entrypoint for all new visitors
    $app->group('/api/v1/authorize', function (RouteCollectorProxy $routeGroup) {
        //Open routes
        $routeGroup->post('/provider/{authProvider}', [$this->get(AuthorizationControllerInterface::class),'authorizeIdtoken']);
    })->add($app->getContainer()->get(AuthorizationInitMiddlewareInterface::class));
    //
    //Registrant-only routes
    $app->group('/api/v1/onboarding', function (RouteCollectorProxy $group) use($app){
        //supercat/?terms
        //Execute a search
        $group->get('/activities/search/supercat/{id}', [$this->get(OnboardingControllerInterface::class),'searchActivitiesInSupercat']);
        //list activities by cat and subcat
        $group->get('/activities/list/cat/{id}', [$this->get(OnboardingControllerInterface::class),'getActivitiesInCcat']);
        $group->get('/activities/list/subcat/{id}', [$this->get(OnboardingControllerInterface::class),'getActivitiesInSubcat']);
        //Activity info
        //$group->get('/activity/info/{id}', [$this->get(GOnboardingControllerInterface::class),'getActivityInfoById']);

        //Gather feedback
        $group->post('/feedback', [$this->get(OnboardingControllerInterface::class),'gatherFlybyFeedback']);

        //Register new user
        $group->post('/register', [$this->get(OnboardingControllerInterface::class),'registerApplicant']);

    })->add($app->getContainer()->get(OnboardingAuthMiddlewareInterface::class));
    //
    //Profile-only routes
    $app->group('/api/v1/account', function (RouteCollectorProxy $group) use($app){
        //Authenticated Routes
        //#########################
        //Main App Usage
        //####
        //Feed
        $group->get('/feed/home', [$this->get(FeedControllerInterface::class),'getFeedLanding']);

        //####
        //Bucketlist
        $group->get('/buckelist/home', [$this->get(BucketlistControllerInterface::class),'getBucketlistLanding']);

        //##
        //Activity - Landing
        $group->get('/offering/home', [$this->get(OfferingControllerInterface::class),'getOfferingsLanding']);

        //##
        //Dashboard

        //##
        //Activity - Search

        //##
        //

        //##
        //

        //##
        //

        //####
        //Shop
        //####
        $group->get('/shop/home', [$this->get(ShopControllerInterface::class),'getShopLanding']);
        //View a shop
        //View items
        //Search for products
        //Categories/subcats/etc
        //Buy/Contact/etc

        //####
        //Profile
        $group->get('/profile/home', [$this->get(ProfileControllerInterface::class),'getProfileLanding']);
        //get profile
        //get dependant profiles
        //get dependant profile
        //Edit
        //Add
        //Delete
        //
        //Operations
        //Add co-guardian
        //Add a Device

        //####
        //Messages
        $group->get('/messages/home', [$this->get(FeedControllerInterface::class),'getMessagesLanding']);
        //List messages
        //Send New message
        //Edit message
        //Delete message
        //Chat Live

        //####
        //Notifications
        $group->get('/notifications/home', [$this->get(NotificationsControllerInterface::class),'getNotificationsLanding']);
        //Mark as read

        //####
        //Other Ops
        //# Share
        //# Rate
        //# Invite

        //# Log-out
        //# Delete Account

        //#########################
        
    })->add($app->getContainer()->get(AuthorizationMiddlewareInterface::class));
    //health endpoints
    //
    //TODO: Add health endpoints
    //
    
    $app->group('/api/v1/healthz', function (RouteCollectorProxy $routeGroup) {
        //Open routes
        $routeGroup->get('/live', [$this->get(HealthzControllerInterface::class),'isLive']);
        $routeGroup->get('/ready', [$this->get(HealthzControllerInterface::class),'isReady']);
    });
    
    
};