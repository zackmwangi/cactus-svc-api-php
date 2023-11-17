<?php
declare(strict_types=1);

namespace App\Middleware\RequestFilter;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

interface RequestFilterMiddlewareInterface
{
    public function __construct();

    public function __invoke(Request $request, RequestHandler $handler);
    

}