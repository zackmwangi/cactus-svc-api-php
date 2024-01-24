<?php
declare(strict_types=1);

namespace App\Middleware\Authorization;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

use Kreait\Firebase\JWT\Error\IdTokenVerificationFailed;// as xIdTokenVerificationFailed;
use Kreait\Firebase\JWT\IdTokenVerifier;// as xIdTokenVerifier;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;// as xFilesystemAdapter;
//
//use Firebase\JWT\JWT;
use \stdClass;

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
        $responseFactory = new \Nyholm\Psr7\Factory\Psr17Factory();

        if (!($request->hasHeader('X-CLIENT-REG-TOKEN') && $request->hasHeader('X-CLIENT-TYPE'))) {
            //BAD REQUEST
            error_log("bad request");
            //
            return $responseFactory->createResponse(400);
        }

        $jwtToken = $request->getHeaderLine('X-CLIENT-REG-TOKEN');

        if(strlen($jwtToken)<10){

            $responseString = "Resource requires authentication";
            $response = $responseFactory->createResponse(401,$responseString);
            return $response->withStatus(401);

        }

        //validate
        try{
            //
            //
            $validatedUserIdTokepayload = $this->validateIdToken($jwtToken);
            //
            if($validatedUserIdTokepayload == false) {
                $responseString = "Resource requires authentication";
            $response = $responseFactory->createResponse(401,$responseString);
            return $response->withStatus(401);

            }
            //else
            //{
                $response = $handler->handle($request);
                return $response;
            //}
            //
        } catch (\Exception $e) {

            $responseString = "Resource requires authentication";
            $response = $responseFactory->createResponse(401,$responseString);
            //return $response->withStatus(401)->withJson(['error' => 'Unauthorized']);
            return $response->withStatus(401);
        }


        

        
        
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

    private function validateIdToken($idToken)
    {
        //echo "$idToken";
        $cache = new FilesystemAdapter();
        $verifier = IdTokenVerifier::createWithProjectIdAndCache($this->jwtSettings['jwtFirebaseProjectId'], $cache);
        //$verifier = IdTokenVerifier::createWithProjectId($this->jwtSettings['jwtFirebaseProjectId']);
        //
        try {
            $token = $verifier->verifyIdToken($idToken);
            return $token->payload();
        } catch (IdTokenVerificationFailed $e) {
            //error_log($e->getMessage());
            return false;
        }

        
    }
}