<?php
declare(strict_types=1);

namespace App\Repository\Activity\Core;

use PDO;
use Exception;

class ActivityRepository implements ActivityRepositoryInterface{

    private $dbConnection;
    //private $defaultLimitCount;

    public function __construct(PDO $dbConnection){
        $this->dbConnection = $dbConnection;
        //$this->defaultLimitCount = 20;
    }
    //
    public function getPDO(){
        return $this->dbConnection;
    }
    //###############
    //Defaults
    public function getActivityById($activityId){}

    //##############################################################################
    //  REGULAR ACTIVITIES
    //get a listing of All activities
    //ALL
    //
    public function getActivities($showKidSuitableOnly=0){}
    
    public function getKidActivities(){
        return $this->getActivities(1);
    }
    //COUNT?? - SQL
    public function getActivitiesCount($showKidSuitableOnly=0){}
    
    public function getKidActivitiesCount(){
        return $this->getActivitiesCount(1);
    }
    //########################

    //Supercat
    public function getKidActivityOptionsInSuperCategory($supercategoryId){
        return $this->getActivityOptionsInSuperCategory($supercategoryId,1);
    }
    //
    public function getActivityOptionsInSuperCategory($supercategoryId, $showKidSuitableOnly=0){}
    //
    //Count eg How many hobbies
    //
    public function getKidActivityCountInSuperCategory($supercategoryId){
        return $this->getActivityCountInSuperCategory($supercategoryId,1);
    }
    //
    public function getActivityCountInSuperCategory($supercategoryId, $showKidSuitableOnly=0){}
        
    //########################
    //Cat
    public function getKidActivityOptionsInCategory($categoryId){
        return $this->getActivityOptionsInCategory($categoryId,1);
    }
    //
    public function getActivityOptionsInCategory($categoryId, $showKidSuitableOnly=0){

    }
    //
    //Count
    //
    public function getKidActivityCountForCategory($categoryId){
        return $this->getActivityCountForCategory($categoryId,1);
    }
    //
    public function getActivityCountForCategory($categoryId, $showKidSuitableOnly=0){

    }
    //########################
    //subcat
    public function getKidActivityOptionsInSubCategory($subcategoryId){
        return $this->getActivityOptionsInSubCategory($subcategoryId,1);
    }
    //
    public function getActivityOptionsInSubCategory($subcategoryId, $showKidSuitableOnly=0){

    }
    //
    //Count 
    public function getKidActivityCountForSubCategory($subcategoryId){
        return $this->getActivityCountForSubCategory($subcategoryId,1);
    }
    //
    public function getActivityCountForSubCategory($subcategoryId, $showKidSuitableOnly=0){

    }
    //##############################################################################
    //  POPULAR ACTIVITIES
    //
    //
    //popular activities in super-category
    //
    public function getPopularKidActivityOptionsInSuperCategory($supercategoryId){
        return $this->getPopularActivityOptionsInSuperCategory($supercategoryId,1);
    }
    //
    public function getPopularActivityOptionsInSuperCategory($supercategoryId, $showKidSuitableOnly=1){
        //
        $visibleValue = 1;
        $show_kid = 1;
        //
        if($showKidSuitableOnly == 1){
            $stmt = $this->dbConnection->prepare("SELECT * FROM nacha_core_a_activity_by_category_with_supercategory WHERE supercat_uuid = :supercat_uuid AND visible = :visible AND show_kid = :show_kid LIMIT 10");
            
        }else{
            $stmt = $this->dbConnection->prepare("SELECT * FROM nacha_core_a_activity_by_category_with_supercategory WHERE supercat_uuid = :supercat_uuid AND visible = :visible LIMIT 10");
        }
        
        $stmt->bindParam(':supercat_uuid', $supercategoryId);
        $stmt->bindParam(':visible', $visibleValue);
        $stmt->bindParam(':show_kid',$show_kid);

        $stmt->execute();
        $data = $stmt->fetchAll();
        return $data;

        
    }
    /*
    public function getPopularKidActivityCountInSuperCategory($supercategoryId){
        return $this->getPopularActivityCountInSuperCategory($supercategoryId,1);
    }
    //
    public function getPopularActivityCountInSuperCategory($supercategoryId, $showKidSuitableOnly=0){
        
    }
    */
     //########################

    //popular activities in category
    //
    public function getPopularKidActivityOptionsInCategory($categoryId){
        return $this->getPopularActivityOptionsInCategory($categoryId,1);
    }
    //
    public function getPopularActivityOptionsInCategory($categoryId, $showKidSuitableOnly=0){
        //
        $visibleValue = 1;
        $show_kid = 1;
        //$defaultLimit = $this->defaultLimitCount;

        //
        if($showKidSuitableOnly == 1){
            error_log("showkidonly = 1");
            $stmt = $this->dbConnection->prepare("SELECT * FROM nacha_core_a_activity_by_category_with_supercategory WHERE cat_uuid = :cat_uuid AND visible = :visible AND show_kid = :show_kid LIMIT 20");
            
        }else{
            error_log("showkidonly = 0");
            $stmt = $this->dbConnection->prepare("SELECT * FROM nacha_core_a_activity_by_category_with_supercategory WHERE cat_uuid = :cat_uuid AND visible = :visible LIMIT 20");
        }

        $stmt->bindParam(':cat_uuid', $categoryId);
        $stmt->bindParam(':visible', $visibleValue);
        $stmt->bindParam(':show_kid',$show_kid);

        $stmt->execute();
        $data = $stmt->fetchAll();
        return $data;

    }
    //
    //
    /*
    public function getPopularKidActivityCountForCategory($categoryId){
        return $this->getPopularActivityCountForCategory($categoryId,1);
    }
    //
    //
    public function getPopularActivityCountForCategory($categoryId, $showKidSuitableOnly=0){

    }
    */
    //
    //########################
    //
    //popular activities in sub-category
    //
    public function getPopularKidActivityOptionsInSubCategory($subcategoryId){
        return $this->getPopularActivityOptionsInSubCategory($subcategoryId,1);
    }
    //
    public function getPopularActivityOptionsInSubCategory($subcategoryId, $showKidSuitableOnly=0){
        
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
    /*
    public function getPopularKidActivityCountForSubCategory($subcategoryId){
        return $this->getPopularActivityCountForSubCategory($subcategoryId,1);
    }
    //
    public function getPopularActivityCountForSubCategory($subcategoryId, $showKidSuitableOnly=0){

    }
    */
    //  #
    //##############################################################################
    public function searchKidActivityOptionsInSuperCategory($supercategoryId){
        return $this->searchActivityOptionsInSuperCategory($supercategoryId,1);
    }
    //
    public function searchActivityOptionsInSuperCategory($supercategoryId, $showKidSuitableOnly=0){

    }
    //
}