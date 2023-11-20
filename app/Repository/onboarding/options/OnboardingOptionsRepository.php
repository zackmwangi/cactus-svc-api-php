<?php
declare(strict_types=1);

namespace App\Repository\Onboarding\Options;

use App\Repository\Onboarding\Options\OnboardingOptionsRepositoryInterface;

use PDO;
use Exception;

class OnboardingOptionsRepository implements  OnboardingOptionsRepositoryInterface{

    private $dbConnection;
    /*
    //
    private $tableSupercategoryByUuid;
    //
    private $tableCategoryByUuid;
    //
    private $tableSubcategoryByUuid;
    //
    private $tableActivityByUuid;
    private $tableActivityBySubcat;
    */
    

    public function __construct(PDO $dbConnection){
        //
        $this->dbConnection = $dbConnection;
        //
        /*
        $this->tableSupercategoryByUuid = "activity_supercat_by_uuid";
        $this->tableCategoryByUuid = "activity_category_by_uuid";
        $this->tableSubcategoryByUuid = "activity_subcategory_by_uuid";
        $this->tableActivityByUuid = "activity_by_uuid";
        $this->tableActivityBySubcat = "activity_by_subcat";
        */
        //
    }

    public function getPDO(){
        return $this->dbConnection;
    }

    //###############
    //Defaults
    //public function getSupercategoriesForKids($showKidSuitableOnly=1){

    //}

    public function getSupercategories($showKidSuitableOnly=1){

        //$table = $this->tableSupercategoryByUuid;
        $visibleValue = 1;
        //Show only if suiteble for kids, set to zero to include adult stuff
        $show_kid = 1;

        if($showKidSuitableOnly == 1){
            $stmt = $this->dbConnection->prepare("SELECT * FROM activity_supercat_by_uuid WHERE visible = :visible AND show_kid = :show_kid LIMIT 5");
        }
        else{
            //include adult stuff
            $stmt = $this->dbConnection->prepare("SELECT * FROM activity_supercat_by_uuid WHERE visible = :visible LIMIT 5");

        }

        
        $stmt->bindParam(':visible', $visibleValue);
        $stmt->bindParam(':show_kid',$show_kid);
        $stmt->execute();
        $data = $stmt->fetchAll();
        return $data;

    }

    public function getKidCategoriesInSupercat($supercategoryId){
        return $this->getCategoriesInSupercat($supercategoryId,1);
    }
    public function getCategoriesInSupercat($supercategoryId, $showKidSuitableOnly=0){

        $returnArr = [];
        return $returnArr;
    }
    //
    //
    public function getKidSubcategoriesInCat($categoryId){
        return $this->getSubcategoriesInCat($categoryId,1);
    }
    public function getSubcategoriesInCat($categoryId, $showKidSuitableOnly=0){
        //
        $subcatPayloadX1['uuid'] = 'a96bec90-809d-11ee-8fd4-67bd7e40c726';
        $subcatPayloadX1['name'] = 'Clothing';

        $subcatPayloadX2['uuid'] = 'ab35cda2-809d-11ee-8fd4-67bd7e40c726';
        $subcatPayloadX2['name'] = 'Cooking';

        $returnArr = [
            $subcatPayloadX1,
            $subcatPayloadX1
        ];
        
        return $returnArr;
    }
    //
    //
    public function getPopularKidActivityOptionsForSuperCategory($supercategoryId){
        return $this->getPopularActivityOptionsForSuperCategory($supercategoryId,1);
    }
    public function getPopularActivityOptionsForSuperCategory($supercategoryId, $showKidSuitableOnly=0){
        //Find most popular kid activities in a supercategory
        
        $activityPayloadX1['uuid'] = '9820d254-8109-11ee-8fd4-67bd7e40c726';
        $activityPayloadX1['name'] = 'Crocheting';

        $activityPayloadX2['uuid'] = '374ebc2e-810a-11ee-8fd4-67bd7e40c726';
        $activityPayloadX2['name'] = 'Roasting & Barbecue';
        //
        $returnArr = [
            $activityPayloadX1,
            $activityPayloadX2
        ];

        return $returnArr;
    }
    //
    //
    public function getPopularKidActivityOptionsForCategory($categoryId){
        return $this->getPopularActivityOptionsForCategory($categoryId,1);
    }
    public function getPopularActivityOptionsForCategory($categoryId, $showKidSuitableOnly=0){
        //
        //Find most popular kid activities in a category
        $activityPayloadX1['uuid'] = '9820d254-8109-11ee-8fd4-67bd7e40c726';
        $activityPayloadX1['name'] = 'Crocheting';

        $activityPayloadX2['uuid'] = '374ebc2e-810a-11ee-8fd4-67bd7e40c726';
        $activityPayloadX2['name'] = 'Roasting & Barbecue';
        //
        $returnArr = [
            $activityPayloadX1,
            $activityPayloadX2
        ];

        return $returnArr;
    }
    //
    //
    public function getPopularKidActivityOptionsForSubCategory($subcategoryId){
        return $this->getPopularActivityOptionsForSubCategory($subcategoryId,1);
    }
    public function getPopularActivityOptionsForSubCategory($subcategoryId, $showKidSuitableOnly=0){
        //Find most popular kid activities in a subcategory
        //
        //Find most popular kid activities in a category
        $activityPayloadX1['uuid'] = '9820d254-8109-11ee-8fd4-67bd7e40c726';
        $activityPayloadX1['name'] = 'Crocheting';

        $activityPayloadX2['uuid'] = '374ebc2e-810a-11ee-8fd4-67bd7e40c726';
        $activityPayloadX2['name'] = 'Roasting & Barbecue';
        //
        $returnArr = [
            $activityPayloadX1,
            $activityPayloadX2
        ];

        return $returnArr;
    }
    //
    //###############
    //Search
    //
    //
    public function getKidActivityOptionsForSuperCategory($supercategoryId){
        return $this->getActivityOptionsForSuperCategory($supercategoryId,1);
    }
    public function getActivityOptionsForSuperCategory($supercategoryId, $showKidSuitableOnly=0){

    }
    //
    //
    public function getKidActivityOptionsForCategory($categoryId){
        return $this->getActivityOptionsForCategory($categoryId,1);
    } 
    public function getActivityOptionsForCategory($categoryId, $showKidSuitableOnly=0){
        
    }
    //
    //
    public function getKidActivityOptionsForSubCategory($subcategoryId){
        return $this->getActivityOptionsForSubCategory($subcategoryId,1);
    }
    public function getActivityOptionsForSubCategory($subcategoryId, $showKidSuitableOnly=0){

    }
    //
    //
    public function searchKidActivityOptionsForSuperCategory($supercategoryId){
        return $this->searchActivityOptionsForSuperCategory($supercategoryId,1);
    }
    public function searchActivityOptionsForSuperCategory($supercategoryId, $showKidSuitableOnly=0){

    }
    //

}
