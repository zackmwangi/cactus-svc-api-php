<?php
declare(strict_types=1);

namespace App\Middleware\Authorization;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

use App\Middleware\Authorization\OnboardingAuthMiddlewareInterface;

class OnboardingAuthMiddleware implements OnboardingAuthMiddlewareInterface
{
    private $jwtSettings;

    public function __construct(array $jwtSettings)
    {
        $this->jwtSettings = $jwtSettings;
    }

    public function __invoke(Request $request, RequestHandler $handler)
    {
        
        $jwtToken = $request->getHeaderLine('X-CLIENT-JWT-TOKEN');

        if(strlen($jwtToken)<10){

            $responseString = "Resource requires authentication";

            $responseFactory = new \Nyholm\Psr7\Factory\Psr17Factory();
            $response = $responseFactory->createResponse(401,$responseString);
            return $response->withStatus(401);

        }
        
        $response = $handler->handle($request);
        return $response;

        //
        //X-CLIENT-TOKEN-VAL
        /*
        // Retrieve the JWT token from the Authorization header
        $token = $request->getHeaderLine('Authorization');
        $token = str_replace('Bearer ', '', $token);

        if (empty($token)) {
            return $response->withStatus(401)->withJson(['error' => 'Unauthorized']);
        }

        try {
            // Verify and decode the JWT token
            $decoded = JWT::decode($token, $this->secretKey, array('HS256'));
            // Add the user information to the request for use in controllers
            $request = $request->withAttribute('user', $decoded);
        } catch (\Exception $e) {
            return $response->withStatus(401)->withJson(['error' => 'Unauthorized']);
        }

        // Call the next middleware or the route handler
        $response = $next($request, $response);
        return $response;
        */
        //
        //
    }
}