<?php
declare(strict_types=1);

namespace App\Repository\Onboarding;

use PDO;
use Exception;

class OnboardingRepository implements  OnboardingRepositoryInterface{
    private $dbConnection;
    //private $authProvider;

    private $onboardingRegistrantRepository;
    private $onboardingOptionsRepository;
    

    public function __construct(PDO $dbConnection, bool $useRegistrationWhitelist = false){
        $this->dbConnection = $dbConnection;
        //$this->authProvider = $authProvider;

    }

    public function getPDO(){
        return $this->dbConnection;
    }

    public function getAuthProvider(){
        //return $this->authProvider;
    }




    //
    /*
    //###############
    //Defaults
    public function getSupercategories(){}
    public function getCategoriesinSupercat($supercategoryId){}
    public function getSubcategoriesinCat($categoryId){}
        //
    public function getPopularActivityOptionsForSuperCategory($supercategoryId){}
    public function getPopularActivityOptionsForCategory($categoryId){}
    public function getPopularActivityOptionsForSubCategory($subcategoryId){}
        //
    //###############
    //Search

    public function getActivityOptionsForSuperCategory($supercategoryId){}
        //
    public function getActivityOptionsForCategory($categoryId){}
    public function getActivityOptionsForSubCategory($subcategoryId){}
        //
    public function searchActivityOptionsForSuperCategory($supercategoryId){}
        */


}
