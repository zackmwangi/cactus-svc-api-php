<?php
declare(strict_types=1);

namespace App\Controllers\Authorization;

require __DIR__ . '/../../../vendor/autoload.php';



use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Kreait\Firebase\JWT\Error\IdTokenVerificationFailed;// as xIdTokenVerificationFailed;
use Kreait\Firebase\JWT\IdTokenVerifier;// as xIdTokenVerifier;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;// as xFilesystemAdapter;
//
use Firebase\JWT\JWT;
use UnexpectedValueException;
//use Firebase\JWT\Key;
//use Google\Client as GooGleClient;
//use Google\Service\Books\Resource\Onboarding;
//
use Exception;
use Google\Service\BigtableAdmin\Split;

use App\Repository\Authorization\AuthorizationRepository;

class AuthorizationController implements AuthorizationControllerInterface
{
    private array $jwtSettings;
    private AuthorizationRepository$authorizationRepository;
    private int $maxFlyBySightings;
    
    public function __construct(array $jwtSettings, AuthorizationRepository $authorizationRepository)
    {
        $this->jwtSettings = $jwtSettings;
        $this->authorizationRepository = $authorizationRepository;
        $this->maxFlyBySightings = 20;//TODO: move this to Settings
    }
    
    
    public function authorizeIdtoken(Request $request, Response $response, array $args){


        if (!($request->hasHeader('X-CLIENT-ID-TOKEN')&&$request->hasHeader('X-CLIENT-TYPE'))) {
            //BAD REQUEST
            //Abort authorization
            $data = ['error' => 'Bad Request'];
            $payload = json_encode($data);
            $response->getBody()->write($payload);
            return $response->withStatus(400);
        }

        //read details from clientId Header
        $authProvider = $args['authProvider'];
        $clientTypeArray = $request->getHeader('X-CLIENT-TYPE');
        $clientType = trim($clientTypeArray[0]);
        $clientIdTokenArray = $request->getHeader('X-CLIENT-ID-TOKEN');
        $clientIdToken = trim($clientIdTokenArray[0]);

        //return by authprovider
        switch($authProvider){
            case 'google':
            default:
            return $this->authorizeIdtokenGoogle($clientIdToken, $response);
            break;
        }

    }

    private function authorizeIdtokenGoogle(String $clientIdToken, Response $response){
        
        try{

            $payload = $this->validateIdToken($clientIdToken);
            //var_dump($payload);
            //die(var_dump($payload));

            if($payload) {
                //
                //########################################
                // Valid Google user
                // Generate our own JWT token and issue it
                //
                //data from presented idToken
                $clientIdTokenLoginProvider = 'google.com';
                $clientIdTokenSub = $payload['sub'];
                //
                //####
                //
                $fullname = trim($payload['name']);
                $firstname = '';
                $lastname = '';
                $avatarUrl = trim($payload['picture']);
                $userEmail = $payload['email'];
                //
                if(strlen($fullname)>0){
                    $name_parts = explode(" ", $fullname);
                    $firstname = trim($name_parts[0]);
                    $lastname = trim($name_parts[1]);
                }
                //
                //###################################################################
                //
                // Deter Rogue Actors/Forbidden users(badlist)
                //
                if($this->authorizationRepository->getBadListedGuardianStatusByEmail($userEmail)){
                    return $response->withStatus(403);
                }

                $existingGuardianData = $this->authorizationRepository->getGuardianByEmail($userEmail);
                
                $nowTime = date("Y-m-d h:i:sa");
                $nowTime4Db = date("Y-m-d H:i:s");

                if($existingGuardianData){
                    //
                    //guardian exists, use existing info
                    //
                    //From internal
                    //
                    $userUuid = $existingGuardianData["guardian_uuid"];
                    $username = '@REGuser:'.$userEmail ;
                    $userType = 'GUARDIAN_REG';
                    $onboarded = '1';
                    $accCreatedAt = $existingGuardianData["created_at"];
                    
                    $firstname = $existingGuardianData["firstname"];
                    $lastname = $existingGuardianData["lastname"];
                    $fullname = $firstname." ".$lastname;
                    //
                    //picture
                    //TODO: verify proper picture URL
                    $avatarUrlFromDb = trim($existingGuardianData["picture_url"]);
                    if(strlen($avatarUrlFromDb)>0){
                        $avatarUrl =  $avatarUrlFromDb;
                    }

                    //Update login info for this user
                    // 
                    
                    // update recent logins text, use a json blob
                    $previousLogins = $existingGuardianData["recent_logins"];
                    //
                    $updateGuardianLoginInfo = $this->authorizationRepository->updateGuardianLoginInfo(
                        $userEmail,
                        $userUuid,
                        $nowTime,
                        $previousLogins
                    );

                    $accLastLogin = $nowTime;

                    if($updateGuardianLoginInfo){
                        //$recentLogins = $updateGuardianLoginInfo['updatedRecentLogins'];
                        $recentLogins = $previousLogins;
                    }else{
                        //TODO: Send system alert of this failure
                        //$accLastLogin = $nowTime;
                        $recentLogins = $previousLogins;
                    }
                }
                else
                {
                    //
                    //new guardian registrant required
                        //use whitelist?
                    $requireRegistrantWhitelisiting = $this->authorizationRepository->useRegistrationWhitelist();
                    //
                    if($requireRegistrantWhitelisiting){
                        //Ensure whitelisted user
                        $registrantIsWhitelisted = $this->authorizationRepository->getWhitelistedRegistrantGuardianExistsByEmail($userEmail);
                        if(!$registrantIsWhitelisted){
                            return $response->withStatus(401);
                        }
                        //else{
                            //insert 
                        //}
                    }
                    //
                    //
                    // kill too many flyby attempts
                    //
                    //
                    $registrantIsReturning = $this->authorizationRepository->getFlybyRegistrantGuardianExistsByEmail($userEmail);

                    //die($registrantIsReturning);
                    //
                    //
                    if($registrantIsReturning){
                        // fetch older data
                        $returningRegistrantData = $this->authorizationRepository->getFlybyRegistrantGuardianByEmail($userEmail); 
                        //die(var_dump($returningRegistrantData));
                        //
                        $flyByCurrentCount = intval($returningRegistrantData['flyby_count']);
                        //
                        if($flyByCurrentCount>=$this->maxFlyBySightings){
                            return $response->withStatus(403);
                        }
                        //
                        $flyByCount = $flyByCurrentCount+1;
                        //
                        $flyByData = [
                            'email' => $userEmail,
                            'flyby_at' => $nowTime4Db,
                            'flyby_count' => $flyByCount,
                        ];

                        $sighting = $this->authorizationRepository->updateFlybyRegistrantGuardian($flyByData);
                    }
                    else
                    {
                        //
                        //
                        //Log registrant flyby in case they abort, to ping them later if still not set up maxWait after
                        //$flyByAt = $nowTime4Db;
                        $flyByReminder1At = date("Y-m-d H:i:s",strtotime("+1 days"));
                        $flyByReminder2At = date("Y-m-d H:i:s",strtotime("+3 days"));
                        $flyByValidUntil = date("Y-m-d H:i:s",strtotime("+7 days"));

                        $flyByData = [
                            'name' => $fullname,
                            'email' => $userEmail,
                            'flyby_at' => $nowTime4Db,
                            'reminder_1_schedule_for'=> $flyByReminder1At,
                            'reminder_2_schedule_for'=> $flyByReminder2At,
                            'valid_until'=> $flyByValidUntil,
                        ];
                        //
                        //

                        $sighting = $this->authorizationRepository->logFlybyRegistrantGuardian($flyByData);
                    }

                    if(!$sighting){
                        return $response->withStatus(500);
                    }
                    //
                    //
                    $userUuid = 'CACTUS-000X-'.$userEmail;
                    $username = '@newuser:'.$userEmail ;
                    $userType = 'GUARDIAN_NEW';
                    $onboarded = '0';
                    $accCreatedAt = $nowTime;
                    $accLastLogin = $nowTime;
                    $recentLogins = 'None';
                    //

                }
                //###################################################################
                //
                $token = $this->generateToken([
                    'name'=>$fullname,
                    'picture'=>trim($payload['picture']),
                    'iss'=> $this->jwtSettings['jwtIss'],
                    'aud' => $this->jwtSettings['jwtAud'],
                    'sub' => $userUuid,
                    'email'=>$payload['email'],
                    'sign_in_provider' =>$clientIdTokenLoginProvider,
                ]);
                //
                $userData = [
                    'uid' => $userUuid,
                    'userToken' => $token,
                    'onboarded' => $onboarded,
                    'email' => $userEmail,
                    'avatarUrl' => $avatarUrl,
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'fullname' => $fullname,
                    'username' => $username,
                    'accountCreatedAt' => $accCreatedAt,
                    'accountLastLogin' => $accLastLogin,
                    'userType'=>$userType,
                    'loginProvider'=>$clientIdTokenLoginProvider,
                    'loginProviderSub'=>$clientIdTokenSub,
                    'recentLogins'=>$recentLogins,
                ];
                //
                $payload = json_encode($userData);
                $response->getBody()->write($payload);
                //
                return $response;
                //
            }else{
                //die(var_dump($payload));
                return $response->withStatus(401);
            }
            
            //################################################################

        }catch (Exception $e) {
            //die(var_dump($e->getMessage()));;
            return $response->withStatus(401);
        }

    }

    private function validateIdToken($idToken)
    {
        
        $cache = new FilesystemAdapter();
        $verifier = IdTokenVerifier::createWithProjectIdAndCache($this->jwtSettings['jwtFirebaseProjectId'], $cache);
        //$verifier = IdTokenVerifier::createWithProjectId($this->jwtSettings['jwtFirebaseProjectId']);
        
        //
        try {
            $token = $verifier->verifyIdToken($idToken);
            //var_dump($token->payload());
            return $token->payload();
        } catch (IdTokenVerificationFailed $e) {
            //var_dump($e->getMessage());
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