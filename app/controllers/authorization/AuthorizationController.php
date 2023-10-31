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
use UnexpectedValueException;
//use Firebase\JWT\Key;
//use Google\Client as GooGleClient;
//use Google\Service\Books\Resource\Onboarding;
//
use Exception;
use \stdClass;
use Google\Service\BigtableAdmin\Split;

use App\Controllers\Authorization\AuthorizationControllerInterface;
use App\Repository\Authorization\AuthorizationRepository;

class AuthorizationController implements AuthorizationControllerInterface
{
    private $jwtSettings;
    private $authorizationRepository;
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

    
    public function __construct(array $jwtSettings, AuthorizationRepository $authorizationRepository)
    {
        $this->jwtSettings = $jwtSettings;
        $this->authorizationRepository = $authorizationRepository;
        //
        //Registrant Defaults
        $this->flyByMaxSightings = 50;//TODO: move this to Settings
        //
        $this->flyByReminder1Days = '1';
        $this->flyByReminder2Days = '3';
        $this->flyByInvalidAfterDays = '30';
        //
        $this->geoLocationInfo = null;
        $this->validatedUserpayload = null;
        $this->geoLocationInfo = new stdClass();
        //
        $this->defaultLocationCountryCode = '';
        $this->defaultLocationLoc = '';
        //
        $this->bithdayStartDate = '';
        $this->bithdayStopDate = '';
        //
        $this->defaultGender = 'F';
        $this->defaultAccountType = 'GUARDIAN';
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

        //GeoLocation info
        //geoInfoDefaults
        $geoInfoIpAddress = $_SERVER['REMOTE_ADDR'];
        $geoInfoCountryCode = '';
        $geoInfoCountryName = '';
        $geoInfoCity = '';
        $geoInfoLoc = '';
        $geoInfoLat = '';
        $geoInfoLng = '';
        //
        //$this->geoLocationInfo = new stdClass();
        $this->geoLocationInfo->ip = $geoInfoIpAddress;
        $this->geoLocationInfo->country = $geoInfoCountryCode;
        $this->geoLocationInfo->country_name = $geoInfoCountryName;
        $this->geoLocationInfo->city = $geoInfoCity;
        $this->geoLocationInfo->loc = $geoInfoLoc;
        $this->geoLocationInfo->latitude = $geoInfoLat;
        $this->geoLocationInfo->longitude = $geoInfoLng;
        //
        $geolocation = $request->getAttribute('geolocation');
        if($geolocation!==''){
            $this->geoLocationInfo = $geolocation;
        }
        //
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

            $validatedUserpayload = $this->validateIdToken($clientIdToken);
            
            if($validatedUserpayload != false) {
                //
                $this->validatedUserpayload = $validatedUserpayload;
                //
                $clientIdTokenLoginProvider = 'google.com';
                $clientIdTokenSub = $validatedUserpayload['sub'];
                //
                //
                // Aceess restrictions, email address
                $userEmail = $validatedUserpayload['email'];
                //
                //SEND BAD ACTORS
                if($this->authorizationRepository->getBadListedGuardianStatusByEmail($userEmail)){
                    $response = $response->withAddedHeader('Cactus-reg-status','visitor/blacklisted');
                    return $response->withStatus(403);
                }
                //
                //Whitelisting
                //
                //############################
                // START PREPARING RESPONSE
                //############################
                //populate basic info from the validated token
                //Some SSO just give you a full name, not the parts.
                $fullname = trim($validatedUserpayload['name']);
                $firstname = '';
                $lastname = '';
                $avatarUrl = trim($validatedUserpayload['picture']);
                //
                if(strlen($fullname)>0){
                    $name_parts = explode(" ", $fullname);
                    $firstname = trim($name_parts[0]);
                    $lastname = trim($name_parts[1]);
                }
                //
                $nowTime = date("Y-m-d h:i:sa");
                $nowTime4Db = date("Y-m-d H:i:s");
                $userDataPayload = [];
                //Populate $userDataPayload
                //######################
                //
                $userDataPayload['email'] = $userEmail;
                $userDataPayload['fullname'] = $fullname;
                $userDataPayload['firstname'] = $firstname;
                $userDataPayload['lastname'] = $lastname;
                $userDataPayload['avatarUrl'] = $avatarUrl;
                //
                // Establish if existing or new
                //
                $existingGuardianData = $this->authorizationRepository->getGuardianByEmail($userEmail);
                //
                if($existingGuardianData){
                    //Returning guardian
                    $userDataPayload['REG_STATUS'] = 'EXISTING';
                    
                    //Continue processing Existing user information
                    //TODO:

                }else{
                    //Potential Registrant
                    $userDataPayload['REG_STATUS'] = 'REGISTRANT';

                    $useRegistrationCountryWhitelist = $this->authorizationRepository->useRegistrationCountryWhitelist();
                    //
                    if($useRegistrationCountryWhitelist){

                        $registrantCountryIsWhitelisted = $this->authorizationRepository->getWhitelistedRegistrantCountryByCountryCodeExists($this->geoLocationInfo->country);
                        if(!$registrantCountryIsWhitelisted){
                            $response = $response->withAddedHeader('Cactus-reg-status','registrant/not-on-whitelist-country');
                            return $response->withStatus(403);
                        }
                    }

                    //Check if existing in whitelist if using an email whitelist
                    $useRegistrationEmailWhitelist = $this->authorizationRepository->useRegistrationEmailWhitelist();
                    //
                    if($useRegistrationEmailWhitelist){
                        //Ensure whitelisted user
                        $registrantIsWhitelisted = $this->authorizationRepository->getWhitelistedRegistrantGuardianExistsByEmail($userEmail);
                        if(!$registrantIsWhitelisted){
                            $response = $response->withAddedHeader('Cactus-reg-status','registrant/not-on-whitelist-email');
                            return $response->withStatus(403);
                        }
                    }

                    // continue with the registration of applying user
                    $registrantIsReturning = $this->authorizationRepository->getFlybyRegistrantGuardianExistsByEmail($userEmail);
                    if($registrantIsReturning){
                        //update existing data
                        $returningRegistrantData = $this->authorizationRepository->getFlybyRegistrantGuardianByEmail($userEmail); 
                        //
                        $flyByCurrentCount = intval($returningRegistrantData['flyby_count']);
                        //
                        if($flyByCurrentCount>=$this->flyByMaxSightings){
                            $response = $response->withAddedHeader('Cactus-reg-status','registrant/max-flyby');
                            return $response->withStatus(403);
                        }
                        //
                        $flyByCount = $flyByCurrentCount+1;
                        $flyByData = [
                            'email' => $userEmail,
                            'flyby_at' => $nowTime4Db,
                            'flyby_count' => $flyByCount,
                        ];
                        //
                        $sighting = $this->authorizationRepository->updateFlybyRegistrantGuardian($flyByData);
                        //
                        $response = $response->withAddedHeader('Cactus-reg-status','registrant/return');
                        $response = $response->withStatus(201);

                    }else{
                        //create a new flyby entry with incoming data
                        $flyByReminder1At = date("Y-m-d H:i:s",strtotime("+".$this->flyByReminder1Days." days"));
                        $flyByReminder2At = date("Y-m-d H:i:s",strtotime("+".$this->flyByReminder2Days." days"));
                        $flyByValidUntil = date("Y-m-d H:i:s",strtotime("+".$this->flyByInvalidAfterDays." days"));

                        $flyByData = [
                            'name' => $fullname,
                            'email' => $userEmail,
                            'flyby_at' => $nowTime4Db,
                            'reminder_1_schedule_for'=> $flyByReminder1At,
                            'reminder_2_schedule_for'=> $flyByReminder2At,
                            'valid_until'=> $flyByValidUntil,
                            //###############################
                            'geoinfo_ip_address' => $this->geoLocationInfo->ip,
                            'geoinfo_country_code' => $this->geoLocationInfo->country,
                            'geoinfo_country_name' => $this->geoLocationInfo->country_name,
                            'geoinfo_city' => $this->geoLocationInfo->city,
                            'geoinfo_loc' => $this->geoLocationInfo->loc,
                            'geoinfo_lat' => $this->geoLocationInfo->latitude,
                            'geoinfo_lng' => $this->geoLocationInfo->longitude,
                            //###############################
                        ];
                        //############################
                        $sighting = $this->authorizationRepository->logFlybyRegistrantGuardian($flyByData);
                        //
                        $response = $response->withAddedHeader('Cactus-reg-status','registrant/new');
                        $response = $response->withStatus(201);
                    }

                    if(!$sighting){
                        $response = $response->withAddedHeader('Cactus-reg-status','registrant/server-error');
                        return $response->withStatus(500);
                    }

                    //Proceed with responding to the overall request
                    //
                    $userUuid = 'CACTUS-000X-'.$userEmail;
                    //
                    $cactusJwtToken = $this->generateToken([
                        'name'=>$fullname,
                        'picture'=>$avatarUrl,
                        'iss'=> $this->jwtSettings['jwtIss'],
                        'aud' => $this->jwtSettings['jwtAud'],
                        'sub' => $userUuid,
                        'email'=>$userEmail,
                        'sign_in_provider' =>$clientIdTokenLoginProvider,
                    ]);

                    //Populate
                    //
                    $userDataPayload['cactusJwtSub'] = $userUuid;
                    $userDataPayload['cactusJwtToken'] = $cactusJwtToken;
                    $userDataPayload['loginProvider'] = $clientIdTokenLoginProvider;
                    $userDataPayload['loginProviderSub'] = $clientIdTokenSub;
                    //
                    //$userDataPayload['email'] = $userEmail;
                    //$userDataPayload['fullname'] = $fullname;
                    //$userDataPayload['firstname'] = $firstname;
                    //$userDataPayload['lastname'] = $lastname;
                    //$userDataPayload['avatarUrl'] = $avatarUrl;
                    $userDataPayload['flybyTime'] = $nowTime4Db;
                    //geoinfo
                    $userDataPayload['geoInfoIpAddress'] = $this->geoLocationInfo->ip;
                    $userDataPayload['geoInfoCountryCode'] = $this->geoLocationInfo->country;
                    $userDataPayload['geoInfoCountryName'] = $this->geoLocationInfo->country_name;
                    $userDataPayload['geoInfoCity'] = $this->geoLocationInfo->city;
                    $userDataPayload['geoInfoLoc'] = $this->geoLocationInfo->loc;
                    
                    //Defaults
                    $userDataPayload['inferredGender'] = $this->getInferredGender($firstname, $lastname, $this->geoLocationInfo->country );
                    $userDataPayload['defaultGender'] = $this->defaultGender;
                    //
                    $userDataPayload['birthdayStart'] = $this->bithdayStartDate; //today-18y
                    $userDataPayload['birthdayEnd'] = $this->bithdayStopDate;//today-110y
                    //
                    $userDataPayload['defaultLocationCountryCode'] = $this->defaultLocationCountryCode; //KE
                    $userDataPayload['defaultLocationLoc'] = $this->defaultLocationLoc; //Nairobi
                    $userDataPayload['defaultAccountType'] = $this->defaultAccountType;//INDIVIDUAL
                    //
                    /*
                    $userDataPayload[''] = ;
                    $userDataPayload[''] = ;
                    */
                    //
                    //#######################
                    $responsePayload = json_encode($userDataPayload);
                    $response->getBody()->write($responsePayload);
                    //#######################
                }
                //
                //#######################
                //$responsePayload = json_encode($userDataPayload);
                //$response->getBody()->write($responsePayload);
                return $response;
                //#######################
                //
            }else{
                $response = $response->withAddedHeader('Cactus-reg-status','visitor/auth-invalid');
                return $response->withStatus(401);
            }
            //################################################################
        }catch (Exception $e) {
            $response = $response->withAddedHeader('Cactus-reg-status','visitor/auth-error');
            return $response->withStatus(401);
        }

    }

    private function validateIdToken($idToken)
    {
        
        $cache = new FilesystemAdapter();
        $verifier = IdTokenVerifier::createWithProjectIdAndCache($this->jwtSettings['jwtFirebaseProjectId'], $cache);
        
        //
        try {
            $token = $verifier->verifyIdToken($idToken);
            return $token->payload();
        } catch (IdTokenVerificationFailed $e) {
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

    //######################
    private function getInferredGender(String $firstname, String $lastname, $countryCode){

        $firstname = trim($firstname);
        $lastname = trim($lastname);
        //$countryCode = trim($countryCode);
        //
        $gender = '';

        if($firstname != ''){
            $firstname = ucfirst($firstname);
            switch($firstname){
                    case 'male':
                    case 'Zachary':
                    case 'Zack':
                    case 'Zack':
                    case 'Francis':
                    case 'James':
                    case 'David':
                    case 'Henry':
                    //
                        $gender = 'M';

                break;

                    case 'female':
                    case 'Winfred':
                    case 'Winifred':
                    case 'Mercy':
                    case 'Nelly':
                    case 'Nelius':
                    //
                        $gender = 'F';
                break;

                default:
                $gender = '';
                break;
            }
        }
        //Zachary Mwangi KE = M
        //Winfred Njeri KE = F
        //Mercy Wahome KE = F

        return $gender;

    }

}