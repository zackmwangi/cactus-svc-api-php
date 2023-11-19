<?php
declare(strict_types=1);

namespace App\Repository\Onboarding\Options;

use App\Repository\Onboarding\Options\OnboardingOptionsRepositoryInterface;

use PDO;
use Exception;

class OnboardingOptionsRepository implements  OnboardingOptionsRepositoryInterface{
    private $dbConnection;
    

    public function __construct(PDO $dbConnection){
        $this->dbConnection = $dbConnection;
    }

    public function getPDO(){
        return $this->dbConnection;
    }

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
        //
    public function getActivityOptionsForSuperCategory($supercategoryId){}
        //
    public function getActivityOptionsForCategory($categoryId){}
    public function getActivityOptionsForSubCategory($subcategoryId){}
        //
    public function searchActivityOptionsForSuperCategory($supercategoryId){}
        //

}
