<?php
declare(strict_types=1);

namespace App\Middleware\Authorization;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

interface AuthorizationMiddlewareInterface
{
    

    public function __construct(array $jwtSettings);
    

    //public function __invoke(Request $request, Response $response, $next);
    public function __invoke(Request $request, RequestHandler $handler);
}