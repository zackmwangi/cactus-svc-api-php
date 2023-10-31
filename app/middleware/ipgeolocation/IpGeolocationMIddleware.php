<?php
declare(strict_types=1);

namespace App\Middleware\IpGeolocation;

use ipinfo\ipinfo\IPinfo;
use ipinfo\ipinfo\IPinfoException;
//use Exception;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;



use App\Middleware\IpGeolocation\IpGeolocationMiddlewareInterface;

class IpGeolocationMiddleware implements IpGeolocationMiddlewareInterface
{
    private $IpInfoAccessToken;

    public function __construct(string $IpInfoAccessToken){
        $this->IpInfoAccessToken = $IpInfoAccessToken;
    }

    public function __invoke(Request $request, RequestHandler $handler)
    {
        $ip = $request->getServerParams()['REMOTE_ADDR'];
        $IpInfoSettings = [
            //'cache_ttl' => 172800 //48hrs
        ];
        $client = new IPinfo($this->IpInfoAccessToken,$IpInfoSettings);
        try{
            $geolocationData = $client->getDetails($ip);
            $request = $request->withAttribute('geolocation', $geolocationData);
        
        }catch(IPinfoException $e){
            //IPinfoException
            //Log exception
            $request = $request->withAttribute('geolocation', 'NONE');
        }
        
        $response = $handler->handle($request);
        return $response;
    }
}