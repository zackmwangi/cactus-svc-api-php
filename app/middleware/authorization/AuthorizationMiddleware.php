<?php
declare(strict_types=1);

namespace App\Middleware\Authorization;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

use App\Middleware\Authorization\AuthorizationMiddlewareInterface;

class AuthorizationMiddleware implements AuthorizationMiddlewareInterface
{
    private $jwtSettings;

    public function __construct(array $jwtSettings)
    {
        $this->jwtSettings = $jwtSettings;
    }

    public function __invoke(Request $request, RequestHandler $handler)
    { 
        if (!($request->hasHeader('X-CLIENT-NACHA-ID-TOKEN')&&$request->hasHeader('X-CLIENT-TYPE'))) {
            //BAD REQUEST
            $responseFactory = new \Nyholm\Psr7\Factory\Psr17Factory();
            return $responseFactory->createResponse(400);
        }

        $response = $handler->handle($request);
        return $response;
    }
}