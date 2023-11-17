<?php
declare(strict_types=1);

namespace App\Middleware\CustomHeader;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

use App\Middleware\CustomHeader\CustomHeaderMiddlewareInterface;

class CustomHeaderMiddleware implements CustomHeaderMiddlewareInterface{
    public function __construct(){}

    public function __invoke(Request $request, RequestHandler $handler)
    {
        $response = $handler->handle($request);
        //
        $response = $response->withoutHeader('x-powered-by');
        $response = $response->withHeader('X-Powered-By-Cactus', 'Cactus v31.10.23');
        return $response;
    }
}