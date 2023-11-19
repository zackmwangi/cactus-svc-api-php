<?php
declare(strict_types=1);

namespace App\Controllers\Authorization;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Kreait\Firebase\JWT\Error\IdTokenVerificationFailed;// as xIdTokenVerificationFailed;
use Kreait\Firebase\JWT\IdTokenVerifier;// as xIdTokenVerifier;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;// as xFilesystemAdapter;
//
use Firebase\JWT\JWT;
use \stdClass;

use App\Controllers\Authorization\AuthorizationControllerInterface;
use App\Repository\Authorization\AuthorizationRepository;

class AuthorizationController implements AuthorizationControllerInterface
{
    private $jwtSettings;
    private $authorizationRepository;
    //
    private $validatedUserIdTokepayload;
    //
    ////////////////////////////
    //
    /*
    private $flyByMaxSightings;

    private String $flyByReminder1Days;
    private String $flyByReminder2Days;
    private String $flyByInvalidAfterDays;

    private $geoLocationInfo;
    private $validatedUserpayload;
    private $defaultLocationCountryCode;
    private $defaultLocationLoc;

    private $bithdayStartDate;
    private $bithdayStopDate;

    private $defaultGender;
    private $defaultAccountType;
    */
    //
    ////////////////////////////
    //
    public function __construct(array $jwtSettings, AuthorizationRepository $authorizationRepository)
    {
        $this->jwtSettings = $jwtSettings;
        $this->authorizationRepository = $authorizationRepository;

    }

    public function authorizeIdtoken(Request $request, Response $response, array $args){
        //Check Token validity
        //read details from clientId Header
        

        $clientIdTokenArray = $request->getHeader('X-CLIENT-INIT-ID-TOKEN');
        $clientIdToken = trim($clientIdTokenArray[0]);

        $clientTypeArray = $request->getHeader('X-CLIENT-TYPE');
        $clientType = trim($clientTypeArray[0]);

        $validatedUserIdTokepayload = $this->validateIdToken($clientIdToken);
        //
        if($validatedUserIdTokepayload == false) {
            error_log("invalid user id token: ".$clientIdToken);
            $response = $response->withAddedHeader('Cactus-reg-status','visitor/auth-invalid');
            return $response->withStatus(401);
        }

        $this->validatedUserIdTokepayload = $validatedUserIdTokepayload;
        $authProvider = $args['authProvider'];
        //
        //
            //
            //$validatedUserIdTokepayload = $this->validateIdToken($clientIdToken);
            //
            //-----------------
            //
            //
            switch($authProvider){
                case 'google':
                default:
                //return $this->authorizeIdtokenGoogle($clientIdToken, $response);
                return $response->withStatus(200);
                break;
            }
            //
            //
            //-----------------
       
    }
    //
    private function authorizeIdtokenGoogle(String $clientIdToken, Response $response){

        //Check if user auth profile for google_provider exists
        //read from auth_profiles_google
        //
        //If exists
            //Continue with authorized user
                //Assemble identity data from login profile
                //Respond to request - code 200
                // Existing account

        //if user not exists
            //Continue with authorized registrant
                //Assembe authorized registrant data from onboarding wing
                //Respond to request - code 201
                // Registration
    }
    //
    /*
    private function authorizeIdtokenFacebook(String $clientIdToken, Response $response){
    
    }

    private function authorizeIdtokenApple(String $clientIdToken, Response $response){
    
    }

    private function authorizeIdtokenUserPass(String $clientIdToken, Response $response){
    
    }
    */

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
            error_log($e->getMessage());
            return false;
        }

        
    }

    private function generateToken($data)
    {
        // Generate a JWT token with the provided data
        $issuedAt = time();
        $expirationTime = $issuedAt + $this->jwtSettings['valid_for']; // 1 hour

        $payload = [

            'name' =>$data['name'],
            'picture' =>$data['picture'],
            'iss' =>$data['iss'],
            'aud' =>$data['aud'],
            'sub' =>$data['sub'],
            'email' =>$data['email'],
            'sign_in_provider' =>$data['sign_in_provider'],
            //
            'iat' => $issuedAt,       // Issued at timestamp
            'exp' => $expirationTime, // Expiration time
            //'data' => $data,

        ];
       
        //##########
        return JWT::encode($payload, $this->jwtSettings['secret_key'], $this->jwtSettings['algorithm']);
    }

    
}