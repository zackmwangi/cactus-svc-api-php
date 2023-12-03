<?php
declare(strict_types=1);

namespace App\Repository\Activity\Core;

use PDO;
use Exception;

class SubcategoryRepository implements SubcategoryRepositoryInterface{

    private $dbConnection;

    public function __construct(PDO $dbConnection){
        $this->dbConnection = $dbConnection;
    }

    public function getPDO(){
        return $this->dbConnection;
    }

    //###############
    //Defaults
    public function getSubcategoryById($activityId){}

    //Get All Subcategory
    public function getKidSubcategories($showKidSuitableOnly=1){
        return $this->getSubcategories(1);
    }
    
    public function getSubcategories($showKidSuitableOnly=0){

    }

    public function getKidSubcategoriesCount($showKidSuitableOnly=1){
        return $this->getSubcategoriesCount(1);
    }
    
    public function getSubcategoriesCount($showKidSuitableOnly=0){

    }

    //Get Subcategories in category
    public function getKidSubcategoriesInCategory($categoryUuid, $showKidSuitableOnly=1){
        return $this->getSubcategoriesInCategory($categoryUuid, 1);
    }
    
    public function getSubcategoriesInCategory($categoryUuid, $showKidSuitableOnly=0){
        
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
    
    public function getKidSubcategoriesInCategoryCount($categoryUuid, $showKidSuitableOnly=1){
        return $this->getSubcategoriesInCategoryCount($categoryUuid, 1);
    }
    
    public function getSubcategoriesInCategoryCount($categoryUuid, $showKidSuitableOnly=0){

    }

    //Get Subcategories in Supercategory
    public function getKidSubcategoriesInSupercategory($supercategoryUuid, $showKidSuitableOnly=1){
        return $this->getSubcategoriesInSupercat(1);
    }
    
    public function getSubcategoriesInSupercat($supercategoryUuid, $showKidSuitableOnly=0){

    }

    public function getKidSubcategoriesInSupercategoryCount($supercategoryUuid, $showKidSuitableOnly=1){
        return $this->getSubcategoriesInSupercategoryCount(1);
    }
    
    public function getSubcategoriesInSupercategoryCount($supercategoryUuid, $showKidSuitableOnly=0){

    }


}