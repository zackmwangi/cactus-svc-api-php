<?php
declare(strict_types=1);

namespace App\Repository\Authorization;
//
use App\Repository\Profile\Authprofile\AuthprofileGoogleRepository;
use App\Repository\Profile\Authprofile\AuthprofileAppleRepository;
//
use App\Repository\Onboarding\Registrant\RegistrantGoogleRepository;
use App\Repository\Onboarding\Registrant\RegistrantAppleRepository;
//
use App\Repository\Onboarding\Options\OnboardingOptionsRepository;

//
use App\Util\JwtHelper;

use PDO;
//use PDO\Exception;
use Exception;

use function DI\add;

class AuthorizationRepository implements  AuthorizationRepositoryInterface
{
    private $dbConnection;
    private $jwtSettings;
    //
    private $authProviderName;
    private $authProviderRepoClass;
    private $authProviderRegistrantRepoClass;
    //
    private $useRegistrationCountryWhitelist;
    private $useRegistrationEmailWhitelist;

    private $defaultLocationCountryCode;
    private $defaultLocationLoc;

    private $bithdayStartDate;
    private $bithdayStopDate;

    private $defaultGender;
    private $defaultAccountType;

    #
    public function __construct(PDO $dbConnection, bool $useRegistrationCountryWhitelist=false, bool $useRegistrationEmailWhitelist=false){
        $this->dbConnection = $dbConnection;
        //
        $this->useRegistrationCountryWhitelist = $useRegistrationCountryWhitelist;
        $this->useRegistrationEmailWhitelist = $useRegistrationEmailWhitelist;
        //$this->authProvider = $authProvider;

        $this->defaultLocationCountryCode = 'KE';
        $this->defaultLocationLoc = '-1.286389, 36.817223';
        //
        $this->bithdayStartDate = date("Y-m-d",strtotime("-40150 days"));
        $this->bithdayStopDate = date("Y-m-d",strtotime("-6575 days"));
        //
        $this->defaultGender = 'F';
        $this->defaultAccountType = 'GUARDIAN';
    }

    public function getPDO(){
        return $this->dbConnection;
    }
    //
    public function withProvider($authProvider,$jwtSettings){

        $this->jwtSettings = $jwtSettings;

        switch($authProvider){
            case 'google':
                $authProviderRepoClass = new AuthprofileGoogleRepository($this->dbConnection, $this->useRegistrationEmailWhitelist);
                $this->authProviderRepoClass = $authProviderRepoClass;
                //
                $authProviderRegistrantRepoClass = new RegistrantGoogleRepository($this->dbConnection, $this->useRegistrationEmailWhitelist);
                $this->authProviderRegistrantRepoClass =  $authProviderRegistrantRepoClass;
                //
                $this->authProviderName = $authProvider;
                //
                //return $authProviderRepoClass;
                return $this;
            break;
            case 'apple';
                $authProviderRepoClass = new AuthprofileAppleRepository($this->dbConnection, $this->useRegistrationEmailWhitelist);
                $this->authProviderRepoClass = $authProviderRepoClass;
                //
                $authProviderRegistrantRepoClass = new RegistrantAppleRepository($this->dbConnection, $this->useRegistrationEmailWhitelist);
                $this->authProviderRegistrantRepoClass =  $authProviderRegistrantRepoClass;
                //
                $this->authProviderName = $authProvider;
                //
                //return $authProviderRepoClass;
                return $this;
            break;
            case 'facebook';
            case 'linkedin';
            case 'github';
            case 'microsoft';
            case 'x';
            default:
                return false;
            break;
        }

    }
    //
    public function getAuthProviderName(){
        return $this->authProviderName;
    }
    //
    private function getAuthProviderRepoClass(){
        return $this->authProviderRepoClass;
    }
    //
    private function getAuthProviderRegistrantRepoClass(){
        return $this->authProviderRegistrantRepoClass;
    }
    //
    public function getAuthProfileForIdTokenPayload($validatedUserIdTokePayload){
        $authProviderRepoClass = $this->getAuthProviderRepoClass();
        return $authProviderRepoClass->getAuthProfileForIdTokenPayload($validatedUserIdTokePayload);
    }
    //
    public function getRegistrantProfileForIdTokenPayload($validatedUserIdTokePayload){
        $authProviderRegistrantRepoClass = $this->getAuthProviderRegistrantRepoClass();
        return $authProviderRegistrantRepoClass->getRegistrantProfileForIdTokenPayload($validatedUserIdTokePayload);
    }
    //
    //######################
    //
    public function getAuthProfileCountryBlacklistStatusForIdTokenPayload($country){
        return false;
    }
    //
    public function getAuthProfileCountryWhitelistStatusForIdTokenPayload($country){
        return true;
    }
    //
    public function getAuthProfileBlacklistStatusForIdTokenPayload($validatedUserIdTokePayload){
        return false;
    }
    //
    public function getAuthProfileWhitelistStatusForIdTokenPayload($validatedUserIdTokePayload){
        return true;
    }
    //
    //######################
    //
    public function getRegistrantProfileCountryBlacklistStatusForIdTokenPayload($country){
        return false;
    }
    //
    public function getRegistrantProfileCountryWhitelistStatusForIdTokenPayload($country){
        return true;
    }
    //
    public function getRegistrantProfileBlacklistStatusForIdTokenPayload($validatedUserIdTokePayload){
        return false;
    }
    //
    public function getRegistrantProfileWhitelistStatusForIdTokenPayload($validatedUserIdTokePayload){
        return true;
    }
    //
    //######################
    //
    public function generateAuthprofileResponseMap(){
        return false;
    }
    //
    public function generateRegistrantprofileResponseMapWithInsert(array $flybyData){
        //Insert new user
        $authProviderRegistrantRepoClass = $this->getAuthProviderRegistrantRepoClass();
        $registrantCreated =  $authProviderRegistrantRepoClass->addRegistrant($flybyData);
        //
        //if successful, construct map
        if($registrantCreated == false){
            return false;
        }

        return $this->generateRegistrantprofileResponseMap($flybyData);

    }
    //
    public function generateRegistrantprofileResponseMapWithUpdate(array $flybyData){
        //
        $authProviderRegistrantRepoClass = $this->getAuthProviderRegistrantRepoClass();
        $registrantUpdated =  $authProviderRegistrantRepoClass->updateRegistrantFlyby($flybyData);

        if($registrantUpdated == false){
            return false;
        }

        return $this->generateRegistrantprofileResponseMap($flybyData);

    }

    public function generateRegistrantprofileResponseMap($flybyData){

        //Generate internal token for this user
        //
        $jwtHelper = new JWTHelper($this->jwtSettings);
        //
        $tokenData = [];
        $cactusJwtSub = 'CACTUS-000X-'.$flybyData['email'];
        //
        $tokenData['name'] = $flybyData['fullname'];
        $tokenData['picture'] = $flybyData['avatarUrl'];
        $tokenData['iss'] = $this->jwtSettings['jwtIss'];
        $tokenData['aud'] = $this->jwtSettings['jwtAud'];
        $tokenData['sub'] = $cactusJwtSub;
        $tokenData['email'] = $flybyData['email'];
        $tokenData['sign_in_provider'] = $this->getAuthProviderName();
        //
        //
        $registrantToken = $jwtHelper->generateRegistrantIdToken($tokenData);
        //error_log("");
        //error_log($registrantToken);
        //error_log("");
        //
        //##############################
        //
        $responseMapData = [];
        //
        //Generate internal token for this user
        //Security
        //
        $responseMapData['cactusJwtSub'] = $cactusJwtSub;
        $responseMapData['cactusJwtToken'] = $registrantToken;
        $responseMapData['loginProvider'] = $this->getAuthProviderName();
        $responseMapData['loginProviderSub'] = $flybyData['loginProviderSub'];
        $responseMapData['flybyTime'] = $flybyData['flyby_time'];
        //
        //$responseMapData[''] = '';
        //
        //Basic data
        $responseMapData['defaultAccountType'] =  $this->defaultAccountType;
        $responseMapData['email'] = $flybyData['email'];
        $responseMapData['fullname'] = $flybyData['fullname'];
        $responseMapData['firstname'] = $flybyData['firstname'];
        $responseMapData['lastname'] = $flybyData['lastname'];
        $responseMapData['avatarUrl'] = $flybyData['avatarUrl'];
        //$responseMapData[''] = '';
        //Location
        $responseMapData['geoInfoIpAddress'] = $flybyData['geoinfo_ip_address'];
        $responseMapData['geoInfoCountryCode'] = $flybyData['geoinfo_country_code'];
        $responseMapData['geoInfoCountryName'] = $flybyData['geoinfo_country_name'];
        $responseMapData['geoInfoCity'] = $flybyData['geoinfo_city'];
        $responseMapData['geoInfoLoc'] = $flybyData['geoinfo_loc'];
        //
        $responseMapData['defaultLocationCountryCode'] = $this->defaultLocationCountryCode;//$flybyData['geoinfo_city'];
        $responseMapData['defaultLocationLoc'] = $this->defaultLocationCountryCode;//$flybyData['geoinfo_loc'];
        //$responseMapData[''] = '';
        //Other defaults
        //$userDataPayload['inferredGender'] = $this->getInferredGender($firstname, $lastname, $this->geoLocationInfo->country );
        $userDataPayload['inferredGender'] = '';
        $userDataPayload['defaultGender'] = $this->defaultGender;
        //
        $userDataPayload['birthdayStart'] = $this->bithdayStartDate; //today-18y
        $userDataPayload['birthdayEnd'] = $this->bithdayStopDate;//today-110y

        //######################################################################################
        //######################################################################################
        //
        //$searchDefaultsGuardianPayload = array();
        $searchDefaultsKidPayload = array();
        //
        //##########

        $onboardingOptionsRepo = new OnboardingOptionsRepository($this->dbConnection);

        $kidSupercategories = $onboardingOptionsRepo->getSupercategories();

        if($kidSupercategories != false){
            
            foreach($kidSupercategories as $supercategory){

                //var_dump($supercategory);

                $supercatPayload = [];
                $supercatPayload['uuid'] =  $supercategory['uuid'];
                $supercatPayload['name'] = $supercategory['name'];
                $supercatPayload['description'] = $supercategory['description'];
                //
                $supercatPayload['supercatLandingHeaderText'] = $supercategory['landing_heading'];
                $supercatPayload['supercatLandingDescriptorText'] = $supercategory['landing_descriptor'];
                //
                $supercatPayload['hint_text'] = $supercategory['search_hint'];
                $supercatPayload['header_text_popular_all'] = $supercategory['search_heading_all'];
                $supercatPayload['header_text_popular_cats'] = $supercategory['search_heading_cats'];
                $supercatPayload['supercatMinSelections'] = $supercategory['min_selections_kid'];
                $supercatPayload['supercatMaxSelections'] = $supercategory['max_selections_kid'];
                //
                //Get the popular activities for kids in this supercat
                $popularActivitiesInSupercat = $onboardingOptionsRepo->getPopularKidActivityOptionsForSuperCategory($supercategory['uuid']);
                $popularActivitiesInSupercatPayload = array();
                //
                if($popularActivitiesInSupercat != false){

                    foreach($popularActivitiesInSupercat as $popularActivityInSupercat){

                        $popularActivityInSupercatPayload = [];
                        $popularActivityInSupercatPayload['uuid'] = $popularActivityInSupercat['uuid'];
                        $popularActivityInSupercatPayload['name'] = $popularActivityInSupercat['name'];
                        //
                        $popularActivitiesInSupercatPayload[] = ($popularActivityInSupercatPayload);
                    }
                }
                //TODO: Ensure we replace a blank result with other stuff

                //
                //
                $supercatPayload['popular_in_all'] =  $popularActivitiesInSupercatPayload;
                //
                //
                //###############
                //get the list of popular activities per category
                $kidCategoriesInSupercat = $onboardingOptionsRepo->getKidCategoriesInSupercat($supercategory['uuid']);
                $kidPopularCategoriesPayload = array();
                //
                //
                if($kidCategoriesInSupercat != false){
                    //
                    //for each category in the group
                    foreach($kidCategoriesInSupercat as $kidCategoryInSupercat){
                        //
                        $kidCategoriesInSupercatPayload = [];
                        $kidCategoriesInSupercatPayload['uuid'] = $kidCategoryInSupercat['uuid'];
                        $kidCategoriesInSupercatPayload['name'] = $kidCategoryInSupercat['name'];
                        //
                        //
                        //
                        //1: get popular activities in this category
                            //$kidCategoriesInSupercatPayload['popular_in_cat'];
                            //TODO: remove those in the all group
                        $popularActivitiesInCat = $onboardingOptionsRepo->getPopularKidActivityOptionsForCategory($kidCategoryInSupercat['uuid']);
                        if($popularActivitiesInCat != false){

                            $popularActivitiesInCatPayload = array();
                            foreach($popularActivitiesInCat as $popularActivityInCat){
                                $popularActivityInCatPayload = [];
                                $popularActivityInCatPayload['uuid'] = $popularActivityInCat['uuid'];
                                $popularActivityInCatPayload['name'] = $popularActivityInCat['name'];
                                //
                                $popularActivitiesInCatPayload[] = ($popularActivityInCatPayload);
                            }
                        }
                        //
                        //
                        //2: a: get list of subcat in this category
                            //$kidCategoriesInSupercatPayload['subcats'];
                            //TODO: b: get popular in the subcat
                        $subcategoriesInCat = $onboardingOptionsRepo->getKidSubcategoriesInCat($kidCategoryInSupercat['uuid']);
                        if($subcategoriesInCat != false){

                            $subcategoriesInCatPayload = array();
                            foreach($subcategoriesInCat as $subcategoryInCat){
                                $subcategoryInCatPayload = [];
                                $subcategoryInCatPayload['uuid'] = $subcategoryInCat['uuid'];
                                $subcategoryInCatPayload['name'] = $subcategoryInCat['name'];
                                //
                                $subcategoriesInCatPayload[] = ($subcategoryInCatPayload);
                            }

                        }
                        //
                        $kidPopularCategoriesPayload[] = ($kidCategoriesInSupercatPayload);
                        
                    }


                }
                //
                //
                $supercatPayload['popular_in_cats'] = $kidPopularCategoriesPayload;
                //
                $searchDefaultsKidPayload[] = $supercatPayload;
            }

        }

        //######################################################################################
        //######################################################################################
        /*

       
            //######################################
            //Kid search defaults

            //Hobby

            $searchDefaultsKidPayloadHobby = [
                //Basics
                'uuid' => '',
                'name' => '',
                'supercatLandingHeaderText' => '',
                'supercatLandingDescriptorText' => '',
                //Search
                'hint_text' => '',
                'header_text_popular_all' => '',
                'header_text_popular_cats' => '',
                'supercatMaxSelections' => 5,
                'popular_in_all' => [
                    
                ],
                'popular_in_cats' => [
                    [
                        []
                    ]
                ],

            ];
            //
            //######################################
            //Sport
            $searchDefaultsKidPayloadSport = [];
            //Topic
            $searchDefaultsKidPayloadTopic = [];
            //Career
            $searchDefaultsKidPayloadCareer = [];
            //Charity
            $searchDefaultsKidPayloadCharity = [];
            //
            $searchDefaultsKidPayload = [
                $searchDefaultsKidPayloadHobby,
                $searchDefaultsKidPayloadSport,
                $searchDefaultsKidPayloadTopic,
                $searchDefaultsKidPayloadCareer,
                $searchDefaultsKidPayloadCharity
                
            ];

        */

        
    
        
       //
       //
        //##################################
        /*
        //HOBBY

                    //
                    //###################################################################################
                    // Simulate
                    //Activity
                    //$activityPayloadX1 = [];

                    $activityPayloadX1['uuid'] = '9820d254-8109-11ee-8fd4-67bd7e40c726';
                    $activityPayloadX1['name'] = 'Crocheting';

                    $activityPayloadX2['uuid'] = '374ebc2e-810a-11ee-8fd4-67bd7e40c726';
                    $activityPayloadX2['name'] = 'Roasting & Barbecue';


                    $subcatPayloadX1['uuid'] = 'a96bec90-809d-11ee-8fd4-67bd7e40c726';
                    $subcatPayloadX1['name'] = 'Clothing';

                    $subcatPayloadX2['uuid'] = 'ab35cda2-809d-11ee-8fd4-67bd7e40c726';
                    $subcatPayloadX2['name'] = 'Cooking';
                    //#####################################
                    //
                    $catPayloadX1['uuid'] = '50da5550-809b-11ee-8fd4-67bd7e40c726';
                    $catPayloadX1['name'] = 'Make & Create';
                    $catPayloadX1['popular_in_cat'] = [
                        $activityPayloadX1,
                        $activityPayloadX2
                    ];
                    $catPayloadX1['subcats'] = [
                        $subcatPayloadX1,
                        $subcatPayloadX2
                    ];
                    //
                    //
                    $supercatUuid = '4bad52c6-8118-11ee-8fd4-67bd7e40c726';
                    $supercatName = 'Hobbies & Interests';
                    $supercatLandingHeaderText = 'What hobbies and interests do they enjoy?';
                    $supercatLandingDescriptorText = '';
                    $supercatHintText = ' Search hobbies ';
                    $supercatHeaderTextAll = 'Popular in '.$supercatName;
                    $supercatHeaderTextCats = 'Popular hobbies by category';
                    $supercatPopularAll = [
                        $activityPayloadX1,
                        $activityPayloadX2
                    ];
                    $supercatPopularCats = [
                        //######
                        $catPayloadX1,

                        //######
                    ];
                    $supercatMaxSelections = 5;
                    //
                    //#####################################
                    //
                    $supercatPayload['uuid'] = $supercatUuid;
                    $supercatPayload['name'] = $supercatName;
                    //
                    $supercatPayload['supercatLandingHeaderText'] = $supercatLandingHeaderText;
                    $supercatPayload['supercatLandingDescriptorText'] =  $supercatLandingDescriptorText;
                    //
                    $supercatPayload['hint_text'] = $supercatHintText;
                    $supercatPayload['header_text_popular_all'] = $supercatHeaderTextAll;
                    $supercatPayload['header_text_popular_cats'] = $supercatHeaderTextCats;
                    $supercatPayload['supercatMaxSelections'] = $supercatMaxSelections;
                    $supercatPayload['popular_in_all'] = $supercatPopularAll;
                    $supercatPayload['popular_in_cats'] = $supercatPopularCats;
                    

        */
        //###################################################################################

                    
        
        //##################################
        
        //$searchDefaultsKidPayload= [
            //$supercatPayload
        //];
        
        //
        //$searchDefaultsKidPayload = $searchDefaultsGuardianPayload;
        $searchDefaultsGuardianPayload = $searchDefaultsKidPayload;
        //
        $responseMapData['searchDefaultsGuardian']['supercats'] = $searchDefaultsGuardianPayload;
        $responseMapData['searchDefaultsKid']['supercats'] = $searchDefaultsKidPayload;
        //
        return $responseMapData;

    }

    //
    //######################
    //
    /*
    //Existing user
    public function getAuthProfileForProviderAndTokenId($provider,$tokenId){
        //return
        //Existing user profile
        //or
        //Registrant profile for new registration
    }
    //
    public function getAuthProfileForTokenIdGoogle($tokenId){
        
    }
    //
    public function getAuthProfileForTokenIdApple($tokenId){}
    //
    //public function getAuthProfileForTokenIdFacebook($tokenId){}

    //New Registrant
    public function getRegistrantAuthProfileForProviderAndTokenId($provider,$tokenId){}

    public function getRegistrantAuthProfileForTokenIdGoogle($tokenId){}

    public function getRegistrantAuthProfileForTokenIdApple($tokenId){}

    //public function getRegistrantAuthProfileForTokenIdFacebook($tokenId){}
    //
    //
    */

    
    
}