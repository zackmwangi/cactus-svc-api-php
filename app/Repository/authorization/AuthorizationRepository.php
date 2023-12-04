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
use App\Repository\Accessibility\AccessibilityRepository;
//
use App\Repository\Occupations\OccupationsRepository;

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

    private $birthdayStartDate;
    private $birthdayStopDate;

    private $birthdayKidStartDate;
    private $birthdayKidStopDate;

    private $defaultGender;
    private $defaultAccountType;

    private $occupationSupercategoryId;

    #
    public function __construct(PDO $dbConnection, bool $useRegistrationCountryWhitelist=false, bool $useRegistrationEmailWhitelist=false){
        //
        $this->dbConnection = $dbConnection;
        //
        $this->useRegistrationCountryWhitelist = $useRegistrationCountryWhitelist;
        $this->useRegistrationEmailWhitelist = $useRegistrationEmailWhitelist;
        //$this->authProvider = $authProvider;

        $this->defaultLocationCountryCode = 'KE';
        $this->defaultLocationLoc = '-1.286389, 36.817223';
        //
        $this->birthdayStartDate = date("Y-m-d",strtotime("-40150 days"));
        $this->birthdayStopDate = date("Y-m-d",strtotime("-6575 days"));
        //
        $this->birthdayKidStartDate = date("Y-m-d",strtotime("-6570 days"));
        $this->birthdayKidStopDate = date("Y-m-d",strtotime("-729 days"));
        //
        $this->defaultGender = 'F';
        $this->defaultAccountType = 'GUARDIAN';
        //
        $this->occupationSupercategoryId = "6a26cb1a-8118-11ee-8fd4-67bd7e40c726";
        //
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
        $responseMapData['defaultLocationLoc'] = $this->defaultLocationLoc;//$flybyData['geoinfo_loc'];
        //$responseMapData[''] = '';
        //Other defaults
        //$userDataPayload['inferredGender'] = $this->getInferredGender($firstname, $lastname, $this->geoLocationInfo->country );
        $responseMapData['inferredGender'] = '';
        $responseMapData['defaultGender'] = $this->defaultGender;
        //
        $responseMapData['birthdayStart'] = $this->birthdayStartDate; //today-18y
        $responseMapData['birthdayEnd'] = $this->birthdayStopDate;//today-110y
        //
        $responseMapData['birthdayKidStart'] = $this->birthdayKidStartDate; //today-18y
        $responseMapData['birthdayKidEnd'] = $this->birthdayKidStopDate;//today-110y

        
        //######################################################################################
        // Activity categories
        //
        //$searchDefaultsGuardianPayload = array();
        $searchDefaultsKidPayload = array();
        $accessDefaultsKidPayload = array();
        //
        //##########

        $onboardingOptionsRepo = new OnboardingOptionsRepository($this->dbConnection);
        $kidSupercategories = $onboardingOptionsRepo->getKidSupercategories();

        if($kidSupercategories != false){

            $occupationsRepo = new OccupationsRepository($this->dbConnection);
            
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
                //
                //Get the popular activities for kids in this supercat
                //
                //
                //##############
                /*
                if($supercategory['uuid'] ==  $this->occupationSupercategoryId){
                    //Occupations and Careers
                    $occupationsRepo

                }
                */
                //##############
                //
                //
                $popularActivitiesInSupercatPayload = array();
                //
                if($supercategory['uuid'] ==  $this->occupationSupercategoryId){
                    //Occupations and Careers
                    $popularActivitiesInSupercat = $occupationsRepo->getPopularKidOccupations();

                    //
                    if($popularActivitiesInSupercat != false){

                        foreach($popularActivitiesInSupercat as $popularActivityInSupercat){

                            $popularActivityInSupercatPayload = [];
                            $popularActivityInSupercatPayload['uuid'] = $popularActivityInSupercat['onetsoc_code'];
                            $popularActivityInSupercatPayload['name'] = $popularActivityInSupercat['title'];
                            //
                            $popularActivitiesInSupercatPayload[] = $popularActivityInSupercatPayload;
                        }
                    }
                    //TODO: Ensure we replace a blank result with other stuff

                }
                else
                {
                    $popularActivitiesInSupercat = $onboardingOptionsRepo->getPopularKidActivityOptionsInSuperCategory($supercategory['uuid']);

                    //
                    if($popularActivitiesInSupercat != false){

                        foreach($popularActivitiesInSupercat as $popularActivityInSupercat){

                            $popularActivityInSupercatPayload = [];
                            $popularActivityInSupercatPayload['uuid'] = $popularActivityInSupercat['uuid'];
                            $popularActivityInSupercatPayload['name'] = $popularActivityInSupercat['name'];
                            //
                            $popularActivitiesInSupercatPayload[] = $popularActivityInSupercatPayload;
                        }
                    }
                    //TODO: Ensure we replace a blank result with other stuff
                }
                //
                //
                //
                //
                $supercatPayload['popular_in_all'] =  $popularActivitiesInSupercatPayload;
                //
                //
                //###############
                //get the list of popular activities per category
                $kidPopularCategoriesPayload = array();
                //
                //
                if($supercategory['uuid'] ==  $this->occupationSupercategoryId){
                    //Occupations and Careers
                    $kidCategoriesInSupercat = $occupationsRepo->getKidOccupationCategories();
                }
                else
                {
                    $kidCategoriesInSupercat = $onboardingOptionsRepo->getKidCategoriesInSupercategory($supercategory['uuid']);
                }
                //
                
                //
                //
                if($kidCategoriesInSupercat != false){
                    
                    
                    //
                    //for each category in the group
                    foreach($kidCategoriesInSupercat as $kidCategoryInSupercat){
                        //
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
                        //
                        $popularActivitiesInCatPayload = array();
                        //
                        if($supercategory['uuid'] ==  $this->occupationSupercategoryId){
                            //Occupations and Careers
                            $popularActivitiesInCat = $occupationsRepo->getPopularKidOccupationsInCategory($kidCategoryInSupercat['uuid']);
                            //
                            if($popularActivitiesInCat != false){

                            
                                foreach($popularActivitiesInCat as $popularActivityInCat){
                                    $popularActivityInCatPayload = [];
                                    $popularActivityInCatPayload['uuid'] = $popularActivityInCat['onetsoc_code'];
                                    $popularActivityInCatPayload['name'] = $popularActivityInCat['title'];
                                    //
                                    $popularActivitiesInCatPayload[] = $popularActivityInCatPayload;
                                }
                            }
                            //
                            
                        }
                        else
                        {
                            $popularActivitiesInCat = $onboardingOptionsRepo->getPopularKidActivityOptionsInCategory($kidCategoryInSupercat['uuid']);
                            //
                            if($popularActivitiesInCat != false){

                            
                                foreach($popularActivitiesInCat as $popularActivityInCat){
                                    $popularActivityInCatPayload = [];
                                    $popularActivityInCatPayload['uuid'] = $popularActivityInCat['uuid'];
                                    $popularActivityInCatPayload['name'] = $popularActivityInCat['name'];
                                    //
                                    $popularActivitiesInCatPayload[] = $popularActivityInCatPayload;
                                }
                            }
                            //
                        }
                        
                        
                        //
                        $kidCategoriesInSupercatPayload['popular_in_cat'] = $popularActivitiesInCatPayload;

                        //
                        //
                        //2: a: get list of subcat in this category
                            //$kidCategoriesInSupercatPayload['subcats'];
                            //TODO: b: get popular in the subcat
                        //
                        //
                        if($supercategory['uuid'] ==  $this->occupationSupercategoryId){
                            //Occupations and Careers
                            $popularActivitiesInSupercat = $occupationsRepo->getKidOccupationSubcategoriesInCategory($kidCategoryInSupercat['uuid']);
                        }
                        else
                        {
                            $subcategoriesInCat = $onboardingOptionsRepo->getKidSubcategoriesInCategory($kidCategoryInSupercat['uuid']);
                        }
                        $subcategoriesInCatPayload = array();
                        //
                        //
                        if($subcategoriesInCat != false){

                            foreach($subcategoriesInCat as $subcategoryInCat){
                                $subcategoryInCatPayload = [];
                                $subcategoryInCatPayload['uuid'] = $subcategoryInCat['uuid'];
                                $subcategoryInCatPayload['name'] = $subcategoryInCat['name'];
                                //
                                $subcategoriesInCatPayload[] = $subcategoryInCatPayload;
                            }

                        }
                        //
                        //
                        $kidCategoriesInSupercatPayload['subcats'] = $subcategoriesInCatPayload;


                        //
                        $kidPopularCategoriesPayload[] = $kidCategoriesInSupercatPayload;
                        
                    }


                }

                //
                //
                $supercatPayload['popular_in_cats'] = $kidPopularCategoriesPayload;
                //
                $searchDefaultsKidPayload[] = $supercatPayload;
            }

        }

        //##########
        //######################################################################################
        //# Accessibility Needs
        //
        //##########
        $accessibilityRepo = new AccessibilityRepository($this->dbConnection);
        //
        
        $accessibilitySupercatInfo = $accessibilityRepo->getAccessibilitySupercatInfo();
        //
        if( $accessibilitySupercatInfo != false ){
            
            //error_log('found $accessibilitySupercatInfo with name '.$accessibilitySupercatInfo['name']);
            //
            $accessDefaultsKidPayload['uuid'] = $accessibilitySupercatInfo['uuid'];
            $accessDefaultsKidPayload['name'] = $accessibilitySupercatInfo['name'];
            $accessDefaultsKidPayload['description'] = $accessibilitySupercatInfo['description'];
            //
            $accessDefaultsKidPayload['supercatLandingHeaderText'] = $accessibilitySupercatInfo['landing_heading'];
            $accessDefaultsKidPayload['supercatLandingDescriptorText'] = $accessibilitySupercatInfo['landing_descriptor'];
            //
            $accessDefaultsKidPayload['hint_text'] = $accessibilitySupercatInfo['search_hint'];
            $accessDefaultsKidPayload['header_text_popular_all'] = $accessibilitySupercatInfo['search_heading_all'];
            $accessDefaultsKidPayload['header_text_popular_cats'] = $accessibilitySupercatInfo['search_heading_cats'];
            $accessDefaultsKidPayload['supercatMinSelections'] = $accessibilitySupercatInfo['min_selections_kid'];
            $accessDefaultsKidPayload['supercatMaxSelections'] = $accessibilitySupercatInfo['max_selections_kid'];
            //accessDefaultsKidPayload[''] = $accessibilitySupercatInfo[''];
            //
            //
            //Add commons
            $commonestNeeds = $accessibilityRepo->getKidCommonestAccessNeeds();
            $commonestNeedsPayload = array();
            //
            if($commonestNeeds != false){
                //
                error_log('found $commonestNeeds');
                //
                foreach($commonestNeeds as $commonestNeed){
                    //
                    $commonestNeedPayload = [];
                    //
                    $commonestNeedPayload['uuid'] = $commonestNeed['uuid'];
                    $commonestNeedPayload['name'] = $commonestNeed['name'];
                    $commonestNeedPayload['description'] = $commonestNeed['description'];
                    //$commonestNeedPayload[''] = $commonestNeed[''];
                    //
                    $commonestNeedsPayload[] = $commonestNeedPayload;
                    //
                }
            }
            //
            $accessDefaultsKidPayload['popular_in_all'] = $commonestNeedsPayload;
            //
            //
            //
            $kidAccessCategories = $accessibilityRepo->getKidAccessCategories();
            //
            $kidAccessCategoriesPayload = array();
            //
            if($kidAccessCategories != false){
                //
                error_log('found $kidAccessCategories');
                foreach($kidAccessCategories as $accessCategory){
                    $accessCategoryPayload = [];
                    $accessCategoryPayload['uuid'] = $accessCategory['description'];
                    $accessCategoryPayload['name'] = $accessCategory['name'];
                    $accessCategoryPayload['description'] = $accessCategory['description'];
                    //
                    $accessCategoryNeedsInCat = $accessibilityRepo->getKidAccessNeedsInCategory($accessCategoryPayload['uuid']);
                    $accessCategoryNeedsInCatPayload = array();
                    //
                    if($accessCategoryNeedsInCat !=false){
                        //
                        error_log('found $accessCategoryNeedsInCat');

                        foreach($accessCategoryNeedsInCat as $accessCategoryNeed){
                            //
                            $accessCategoryNeedPayload = [];
                            //
                            $accessCategoryNeedPayload['uuid'] = $accessCategoryNeed['uuid'];
                            $accessCategoryNeedPayload['name'] = $accessCategoryNeed['name'];
                            $accessCategoryNeedPayload['description'] = $accessCategoryNeed['description'];
                            //
                            $accessCategoryNeedsInCatPayload[] = $accessCategoryNeedPayload;
                            //
                        }
                    }
                    //
                    //$accessCategoryPayload[''] = [];
                    //$accessCategoryPayload['subcats'] = [''];

                    //$accessCategoryPayload['access_needs_in_cat'] = $accessCategoryNeedsInCatPayload;
                    $accessCategoryPayload['popular_in_cat'] = $accessCategoryNeedsInCatPayload;
                    //
                    //########
                    $kidAccessCategoriesPayload[] = $accessCategoryPayload;
                }
            }

            //$accessDefaultsKidPayload['access_needs_in_cats'] = $kidAccessCategoriesPayload;
            $accessDefaultsKidPayload['popular_in_cats'] = $kidAccessCategoriesPayload;

        }

        //######################################################################################
        //
        //$searchDefaultsKidPayload = $searchDefaultsGuardianPayload;
        $searchDefaultsGuardianPayload = $searchDefaultsKidPayload;
        $accessDefaultsGuardianPayload = $accessDefaultsKidPayload;
        //
        $responseMapData['searchDefaultsKid']['supercats'] = $searchDefaultsKidPayload;
        $responseMapData['searchDefaultsKid']['accesscat'] = $accessDefaultsKidPayload;
        $responseMapData['searchDefaultsGuardian']['supercats'] = $searchDefaultsGuardianPayload;
        $responseMapData['searchDefaultsGuardian']['accesscat'] = $accessDefaultsGuardianPayload;

        //$responseMapData['searchDefaultsGuardian']['supercats'] = 
        //
        return $responseMapData;
    }
}