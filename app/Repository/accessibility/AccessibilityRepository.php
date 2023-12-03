<?php
declare(strict_types=1);

namespace App\Repository\Accessibility;

use PDO;

class AccessibilityRepository implements AccessibilityRepositoryInterface{
    private $dbConnection;
    //
    public function __construct(PDO $dbConnection){
        $this->dbConnection = $dbConnection;
    }
    //
    public function getPDO(){
        return $this->dbConnection;
    }
    //
    //###############

    public function addAccessibility($uuid){}

    public function getAccessibilityByUuid($uuid){}

    public function updateAccessibility($uuid){}

    public function deleteAccessibility($uuid){}

    public function getKidCommonestAccessNeeds(){
        return $this->getCommonestAccessNeeds(1);
    }

    public function getCommonestAccessNeeds($showKidSuitableOnly=0){
        //
        //
        $visibleValue = 1;
        $force_featured_at_onboarding_kid = 1;
        //
        $show_kid = 1;

        //
        if($showKidSuitableOnly == 1){
            error_log("getCommonestAccessNeeds showkidonly = 1");
            $stmt = $this->dbConnection->prepare("SELECT * FROM nacha_core_ax_need_by_category_with_supercategory WHERE force_featured_at_onboarding_kid = :force_featured_at_onboarding_kid AND visible = :visible AND show_kid = :show_kid LIMIT 20");
            
        }else{
            error_log("getCommonestAccessNeeds showkidonly = 0");
            $stmt = $this->dbConnection->prepare("SELECT * FROM nacha_core_ax_need_by_category_with_supercategory WHERE force_featured_at_onboarding_kid = :force_featured_at_onboarding_kid AND visible = :visible LIMIT 20");
        }

        $stmt->bindParam(':force_featured_at_onboarding_kid', $force_featured_at_onboarding_kid);
        $stmt->bindParam(':visible', $visibleValue);
        $stmt->bindParam(':show_kid',$show_kid);

        $stmt->execute();
        $data = $stmt->fetchAll();
        return $data;
    }

    public function getAccessibilitySupercatInfo(){
        $visibleValue = 1;
        //$show_kid = 1;

            $stmt = $this->dbConnection->prepare("SELECT * FROM nacha_core_ax_supercategory_by_uuid WHERE visible = :visible LIMIT 1");
        
        $stmt->bindParam(':visible', $visibleValue);
        //$stmt->bindParam(':show_kid',$show_kid);
        $stmt->execute();
        $data = $stmt->fetch();
        return $data;
    }

    public function getKidAccessCategories(){
        return $this->getAccessCategories(1);
    }

    public function getAccessCategories($showKidSuitableOnly=0){
        //
        $visibleValue = 1;
        $show_kid = 1;

        if($showKidSuitableOnly == 1){
            $stmt = $this->dbConnection->prepare("SELECT * FROM nacha_core_ax_category WHERE visible = :visible AND show_kid = :show_kid LIMIT 20");
        }
        else{
            //include adult stuff
            $stmt = $this->dbConnection->prepare("SELECT * FROM nacha_core_ax_category WHERE visible = :visible LIMIT 20");
        }

        //$stmt->bindParam(':supercat_uuid', $supercategoryId);
        $stmt->bindParam(':visible', $visibleValue);
        $stmt->bindParam(':show_kid',$show_kid);
        $stmt->execute();
        $data = $stmt->fetchAll();
        return $data;
    }

    public function getKidAccessNeedsInCategory($categoryId){
        return $this->getAccessNeedsInCategory(1);
    }

    public function getAccessNeedsInCategory($categoryId,$showKidSuitableOnly=1){
        //
        $visibleValue = 1;
        $show_kid = 1;

        if($showKidSuitableOnly == 1){}else{}

        return false;
    }

}

