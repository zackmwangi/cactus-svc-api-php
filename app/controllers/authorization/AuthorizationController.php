<?php
declare(strict_types=1);

namespace App\Controllers\Authorization;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Kreait\Firebase\JWT\Error\IdTokenVerificationFailed;// as xIdTokenVerificationFailed;
use Kreait\Firebase\JWT\IdTokenVerifier;// as xIdTokenVerifier;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;// as xFilesystemAdapter;
//
//use Firebase\JWT\JWT;
use \stdClass;

use App\Controllers\Authorization\AuthorizationControllerInterface;
use App\Repository\Authorization\AuthorizationRepository;
//
use App\Repository\Profile\Authprofile\AuthProfileProviderRepositoryInterface;
//
use App\Repository\Onboarding\OnboardingRepository;
//use App\Repository\Onboarding\Options\OnboardingOptionsRepository;

class AuthorizationController implements AuthorizationControllerInterface
{
    private $jwtSettings;
    private $authorizationRepository;
    //
    private $validatedUserIdTokepayload;
    //
    private $authProviderClass;
    ////////////////////////////
    //
    private String $flyByReminder1Days;
    private String $flyByReminder2Days;
    private String $flyByInvalidAfterDays;
    //
    private $flyByMaxSightings;
    //
    private $bithdayStartDate;
    private $bithdayStopDate;

    private $geoLocationInfo;
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
        //
        $this->flyByMaxSightings = 100;//TODO: move this to Settings
        //
        $this->flyByReminder1Days = '1';
        $this->flyByReminder2Days = '3';
        $this->flyByInvalidAfterDays = '30';
        //
        $this->bithdayStartDate = date("Y-m-d",strtotime("-40150 days"));
        $this->bithdayStopDate = date("Y-m-d",strtotime("-6575 days"));

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
            //
            $errorMessage = "invalid user id token: ";
            //
            //error_log($errorMessage.$clientIdToken);
            //
            $response = $response->withAddedHeader('Cactus-reg-status','visitor/auth-invalid');
            return $response->withStatus(401);
        }
        //
        $this->validatedUserIdTokepayload = $validatedUserIdTokepayload;
        //
        $authProvider = $args['authProvider'];
        //
        //$onboardingRepository = OnboardingRepository();
        $authProviderRepo = $this->authorizationRepository->withProvider($authProvider, $this->jwtSettings);
        //Populate location info
        //
         //#########
         //GeoLocation info
        //geoInfoDefaults
        $geoInfoIpAddress = $_SERVER['REMOTE_ADDR'];
        $geoInfoCountryCode = "";
        $geoInfoCountryName = "";
        $geoInfoCity = "";
        $geoInfoLoc = "";
        $geoInfoLat = 0;
        $geoInfoLng = 0;
        //
         $geolocation = $request->getAttribute('geolocation');
         if(($geolocation!=null || $geolocation!=='') && ($geolocation->ip !='127.0.0.1')){
             if($geolocation->ip !='127.0.0.1'){
                 $geoInfoIpAddress = $geolocation->ip;
                 $geoInfoCountryCode = $geolocation->country;
                 $geoInfoCountryName = $geolocation->country_name;
                 $geoInfoCity = $geolocation->city;
                 $geoInfoLoc = $geolocation->loc;
                 $geoInfoLat = $geolocation->latitude;
                 $geoInfoLng = $geolocation->longitude;
             }
         }
         //#########
         $mygeoLocationInfo = new stdClass();
         //
         $mygeoLocationInfo->ip = $geoInfoIpAddress;
         $mygeoLocationInfo->country = $geoInfoCountryCode;
         $mygeoLocationInfo->country_name = $geoInfoCountryName;
         $mygeoLocationInfo->city = $geoInfoCity;
         $mygeoLocationInfo->loc = $geoInfoLoc;
         $mygeoLocationInfo->latitude = $geoInfoLat;
         $mygeoLocationInfo->longitude = $geoInfoLng;
         //
         $this->geoLocationInfo = $mygeoLocationInfo;
         //#########

        //
        //
        if($authProviderRepo == false){
            $response = $response->withAddedHeader('Cactus-reg-status','auth-provider/auth-provider-invalid');
            return $response->withStatus(400);
        }//else{
            $this->authorizationRepository = $authProviderRepo;
        //}

        //$nowTime = date("Y-m-d h:i:sa");
        $nowTime4Db = date("Y-m-d H:i:s");

        //Check if user exists and
        $existingAuthProfileRow = $this->authorizationRepository->getAuthProfileForIdTokenPayload($validatedUserIdTokepayload);
        //
        if($existingAuthProfileRow != false){
            //user exists, return existing user profile map
            error_log("Found profile row for user with email ".$validatedUserIdTokepayload["email"]);
            //
            //
            $responseMap = $this->authorizationRepository->generateAuthprofileResponseMap($validatedUserIdTokepayload["email"]);
            //
            if($responseMap == false){
                $response = $response->withAddedHeader('Cactus-reg-status','visitor/server-error');
                return $response->withStatus(500);
            }
            //
            return $response->withStatus(200);
            //
        }
        else
        {

            //$authProviderRegistrantRepo = $this->authorizationRepository->get
            //New user or returning registrant 
            //error_log("Register new or find return data for registrant with email ".$validatedUserIdTokepayload["email"]);
            $returningRegistrantRow = $this->authorizationRepository->getRegistrantProfileForIdTokenPayload($validatedUserIdTokepayload);
            //
            if($returningRegistrantRow  !=false ){
                //returning registrant
                //error_log("We have a returning registration with ".$validatedUserIdTokepayload["email"]);
                //
                //check blacklist
                //
                //check whitelists
                //
                //max flyby
                //
                    //$returningRegistrantData = $this->authorizationRepository->getFlybyRegistrantGuardianByEmail($userEmail); 
                    //
                    $flyByCurrentCount = intval($returningRegistrantRow['flyby_count']);
                    //
                    if($flyByCurrentCount>=$this->flyByMaxSightings){
                        $response = $response->withAddedHeader('Cactus-reg-status','registrant/max-flyby');
                        error_log("max flyby attempts exceeded for user " . $validatedUserIdTokepayload["email"]);
                        return $response->withStatus(403);
                    }
                    //
                    $flyByCount = $flyByCurrentCount+1;
                //
                //
                //insert new flyby entry
                //
                $flybyData = [];
                //
                $fullname = trim($validatedUserIdTokepayload["name"]);
                $firstname = '';
                $lastname = '';
                $avatarUrl = trim($validatedUserIdTokepayload['picture']);
                //
                if(strlen($fullname)>0){
                    $name_parts = explode(" ", $fullname);
                    $firstname = trim($name_parts[0]);
                    $lastname = trim($name_parts[1]);
                }

                //
                $flybyData['flyby_count'] = $flyByCount;
                //

                //TODO: Add Geo info to the update
                //
                $flybyData['email'] = $validatedUserIdTokepayload["email"];
                $flybyData['fullname'] = $fullname;
                //
                $flybyData['firstname'] = $firstname;
                $flybyData['lastname'] = $lastname;
                $flybyData['avatarUrl'] = $validatedUserIdTokepayload["picture"];
                //
                $flybyData['geoinfo_ip_address'] = $this->geoLocationInfo->ip;
                $flybyData['geoinfo_country_code'] = $this->geoLocationInfo->country;
                $flybyData['geoinfo_country_name'] = $this->geoLocationInfo->country_name;
                $flybyData['geoinfo_city'] = $this->geoLocationInfo->city;
                $flybyData['geoinfo_loc'] = $this->geoLocationInfo->loc;
                $flybyData['geoinfo_lat'] = $this->geoLocationInfo->latitude;
                $flybyData['geoinfo_lng'] = $this->geoLocationInfo->longitude;
                //
                $flybyData['flyby_time'] = $nowTime4Db;
                $flybyData['created_time'] = $nowTime4Db;
                $flybyData['reminder_1_schedule_time'] =  date("Y-m-d H:i:s",strtotime("+".$this->flyByReminder1Days." days"));;
                $flybyData['reminder_2_schedule_time'] = date("Y-m-d H:i:s",strtotime("+".$this->flyByReminder2Days." days"));
                $flybyData['valid_until_time'] = date("Y-m-d H:i:s",strtotime("+".$this->flyByInvalidAfterDays." days"));
                //
                //#######
                //
                $flybyData['loginProviderSub'] = $validatedUserIdTokepayload["sub"];
                //
                $responseMap = $this->authorizationRepository->generateRegistrantprofileResponseMapWithUpdate($flybyData);
                //
                if($responseMap == false){
                    $response = $response->withAddedHeader('Cactus-reg-status','registrant/server-error');
                    return $response->withStatus(500);
                }
                //
                $response = $response->withAddedHeader('Cactus-reg-status','registrant/return');
                //
            }
            else
            {
                //fresh registrant
                error_log("Doing freesh registration for ".$validatedUserIdTokepayload["email"]);
                //
                //check blacklist
                //
                //check whitelists
                //
                //insert new flyby entry
                $flybyData = [];
                //
                $fullname = trim($validatedUserIdTokepayload["name"]);
                $firstname = '';
                $lastname = '';
                $avatarUrl = trim($validatedUserIdTokepayload['picture']);
                //
                if(strlen($fullname)>0){
                    $name_parts = explode(" ", $fullname);
                    $firstname = trim($name_parts[0]);
                    $lastname = trim($name_parts[1]);
                }
                //
                $flybyData['email'] = $validatedUserIdTokepayload["email"];
                $flybyData['fullname'] = $fullname;
                //
                $flybyData['firstname'] = $firstname;
                $flybyData['lastname'] = $lastname;
                $flybyData['avatarUrl'] = $validatedUserIdTokepayload["picture"];
                //
                $flybyData['geoinfo_ip_address'] = $this->geoLocationInfo->ip;
                $flybyData['geoinfo_country_code'] = $this->geoLocationInfo->country;
                $flybyData['geoinfo_country_name'] = $this->geoLocationInfo->country_name;
                $flybyData['geoinfo_city'] = $this->geoLocationInfo->city;
                $flybyData['geoinfo_loc'] = $this->geoLocationInfo->loc;
                //$flybyData['geoinfo_lat'] = '';
                $flybyData['geoinfo_lat'] = $this->geoLocationInfo->latitude;
                $flybyData['geoinfo_lng'] = $this->geoLocationInfo->longitude;
                //
                $flybyData['flyby_time'] = $nowTime4Db;
                $flybyData['created_time'] = $nowTime4Db;
                $flybyData['reminder_1_schedule_time'] =  date("Y-m-d H:i:s",strtotime("+".$this->flyByReminder1Days." days"));;
                $flybyData['reminder_2_schedule_time'] = date("Y-m-d H:i:s",strtotime("+".$this->flyByReminder2Days." days"));
                $flybyData['valid_until_time'] = date("Y-m-d H:i:s",strtotime("+".$this->flyByInvalidAfterDays." days"));
                //
                //#######
                //
                $flybyData['loginProviderSub'] = $validatedUserIdTokepayload["sub"];
                $responseMap = $this->authorizationRepository->generateRegistrantprofileResponseMapWithInsert($flybyData);
                //
                if($responseMap == false){
                    $response = $response->withAddedHeader('Cactus-reg-status','registrant/server-error');
                    return $response->withStatus(500);
                }
                //
                $response = $response->withAddedHeader('Cactus-reg-status','registrant/new');
                //
            }
            //
            $responsePayload = json_encode($responseMap);
            $response->getBody()->write($responsePayload);
            return $response->withStatus(201);
            //
        }
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

    
    //
    /*
    private function generateRegistrantProfileResponseMap(){}

    private function generateAuthprofileResponseMap(){}
    */

    
}