<?php
declare(strict_types=1);

namespace App\Controllers\Healthz;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class HealthzController implements HealthzControllerInterface
{
    public function __construct(){}

    public function isLive(Request $request, Response $response, array $args){
        return $response->withStatus(200);
    }

    public function isReady(Request $request, Response $response, array $args){
        //if all required resources accessible
        return $response->withStatus(200);
    }

}