<?php
declare(strict_types=1);

use App\Controllers\Authorization\AuthorizationControllerInterface;
use App\Controllers\Guardian\GuardianControllerInterface;
use App\Middleware\Authorization\AuthorizationMiddlewareInterface;
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

    $app->add($app->getContainer()->get(CustomHeaderMiddleware::class));
    $app->add($app->getContainer()->get(IpGeolocationMiddleware::class));
    //
    $app->group('/api/v1', function (RouteCollectorProxy $routeGroup) {

        //var_dump($this->getContainer());


        //$routeGroup->post('/authorize/{authProvider}', AuthorizationController::class. ':authorizeIdtoken');
        $routeGroup->post('/authorize/{authProvider}', [$this->get(AuthorizationControllerInterface::class),'authorizeIdtoken']);
        /*
        $routeGroup->post('/authorize/{authProvider}', function(){

            $callProcessor = $this->get(AuthorizationControllerInterface::class);

            return $callProcessor.authorizeIdtoken();
            //$this->get(AuthorizationControllerInterface::class).auth
        });
        */
        //$routeGroup->post('/authorize/{authProvider}', $this->get('AuthorizationController').':authorizeIdtoken');
        //$this->getContainer()->get
        
        
        
    
        $routeGroup->get('/123', function (Request $request, Response $response) {
            $response->getBody()->write('Hello there 123');
            return $response;
        });
    
        $routeGroup->post('/345', function (Request $request, Response $response) {
            $response->getBody()->write('Hello there post 345');
            return $response;
        });
    
    });
    //
    $app->group('/api/v1', function (RouteCollectorProxy $group) use($app){
        //Authenticated Routes
        $group->get('/user/{id}', [$this->get(GuardianControllerInterface::class),'getUser']);
    })->add($app->getContainer()->get(AuthorizationMiddlewareInterface::class));
    
};