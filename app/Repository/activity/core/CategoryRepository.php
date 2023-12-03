<?php
declare(strict_types=1);

namespace App\Repository\Activity\Core;

use PDO;
use Exception;

class CategoryRepository implements CategoryRepositoryInterface{

    private $dbConnection;

    public function __construct(PDO $dbConnection){
        $this->dbConnection = $dbConnection;
    }

    public function getPDO(){
        return $this->dbConnection;
    }

    //###############
    //Defaults
    public function getCategoryById($activityId){}

    //Get All category
    public function getKidCategories($showKidSuitableOnly=1){
        return $this->getCategories(1);
    }
    
    public function getCategories($showKidSuitableOnly=0){

    }
    //
    public function getKidCategoriesCount($showKidSuitableOnly=1){
        return $this->getCategoriesCount(1);
    }
    
    public function getCategoriesCount($showKidSuitableOnly=0){

    }
    //Get All category in Supercat 
    public function getKidCategoriesInSupercategory($supercategoryId){
        return $this->getCategoriesInSupercategory($supercategoryId,1);
    }
    
    public function getCategoriesInSupercategory($supercategoryId, $showKidSuitableOnly=0){
        
        $visibleValue = 1;
        //Show only if suiteble for kids, set to zero to include adult stuff
        $show_kid = 1;

        if($showKidSuitableOnly == 1){
            $stmt = $this->dbConnection->prepare("SELECT * FROM nacha_core_a_category_by_supercategory WHERE  supercat_uuid = :supercat_uuid AND visible = :visible AND show_kid = :show_kid LIMIT 20");
        }
        else{
            //include adult stuff
            $stmt = $this->dbConnection->prepare("SELECT * FROM nacha_core_a_category_by_supercategory WHERE supercat_uuid = :supercat_uuid  visible = :visible LIMIT 20");
        }

        $stmt->bindParam(':supercat_uuid', $supercategoryId);
        $stmt->bindParam(':visible', $visibleValue);
        $stmt->bindParam(':show_kid',$show_kid);
        $stmt->execute();
        $data = $stmt->fetchAll();
        return $data;

    }
    //
    public function getKidCategoriesInSupercategoryCount($supercategoryId){
        return $this->getCategoriesInSupercategoryCount($supercategoryId,1);
    }
    
    public function getCategoriesInSupercategoryCount($supercategoryId, $showKidSuitableOnly=0){

    }

}