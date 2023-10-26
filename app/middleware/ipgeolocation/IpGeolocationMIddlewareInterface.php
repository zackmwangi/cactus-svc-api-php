<?php
declare(strict_types=1);

namespace App\Middleware\IpGeolocation;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

//use App\Middleware\IpGeolocation\IpGeolocationMiddlewareInterface;

interface IpGeolocationMiddlewareInterface
{
    public function __construct(string $IpInfoAccessToken);

    public function __invoke(Request $request, RequestHandler $handler);
    

    //public function getCountryforIpAddress(string $ipAddress);
}