<?php
declare(strict_types=1);

namespace App\Repository\Activity\Core;

use PDO;
use Exception;

class SupercategoryRepository implements SupercategoryRepositoryInterface{

    private $dbConnection;

    public function __construct(PDO $dbConnection){
        $this->dbConnection = $dbConnection;
    }

    public function getPDO(){
        return $this->dbConnection;
    }

    //###############
    //Defaults
    public function getSupercategoryById($activityId){}

    //Get All Supercategory
    public function getKidSupercategories(){
        return $this->getSupercategories(1);
    }
    
    public function getSupercategories($showKidSuitableOnly=0){
        
        //$table = $this->tableSupercategoryByUuid;
        $visibleValue = 1;
        //Show only if suiteble for kids, set to zero to include adult stuff
        $show_kid = 1;

        if($showKidSuitableOnly == 1){
            $stmt = $this->dbConnection->prepare("SELECT * FROM nacha_core_a_supercategory_by_uuid WHERE visible = :visible AND show_kid = :show_kid LIMIT 5");
        }
        else{
            //include adult stuff
            $stmt = $this->dbConnection->prepare("SELECT * FROM nacha_core_a_supercategory_by_uuid WHERE visible = :visible LIMIT 5");

        }

        
        $stmt->bindParam(':visible', $visibleValue);
        $stmt->bindParam(':show_kid',$show_kid);
        $stmt->execute();
        $data = $stmt->fetchAll();
        return $data;
        

    }
    //
    public function getKidSupercategoriesCount($showKidSuitableOnly=1){
        return $this->getSupercategoriesCount(1);
    }
    
    public function getSupercategoriesCount($showKidSuitableOnly=0){

    }
    //
    

}