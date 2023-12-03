<?php
declare(strict_types=1);

namespace App\Repository\Occupations;

use PDO;

class OccupationsRepository implements OccupationsRepositoryInterface{

    private $dbConnection;
    #

    public function __construct(PDO $dbConnection){
        //
        $this->dbConnection = $dbConnection;
    }

    public function getPDO(){
        return $this->dbConnection;
    }

    

    public function getKidOccupationCategories(){
        return $this->getOccupationCategories(1);

    }

    public function getOccupationCategories($showKidSuitableOnly=0){
        
        $visibleValue = 1;
        $show_kid = 1;

        if($showKidSuitableOnly == 1){
            $stmt = $this->dbConnection->prepare("SELECT * FROM nacha_onet28_occupation_cluster WHERE visible = :visible AND show_kid = :show_kid LIMIT 20");
        }else{
            $stmt = $this->dbConnection->prepare("SELECT * FROM nacha_onet28_occupation_cluster WHERE visible = :visible AND LIMIT 20");
        }
            
        $stmt->bindParam(':visible', $visibleValue);
        $stmt->bindParam(':show_kid',$show_kid);

        $stmt->execute();
        $data = $stmt->fetchAll();
        return $data;

    }
    //
    //###########
    //
    public function getKidOccupationSubcategoriesInCategory($categoryId){
        return $this->getOccupationSubcategoriesInCategory($categoryId,1);
    }

    public function getOccupationSubcategoriesInCategory($categoryId,$showKidSuitableOnly=0){

        $visibleValue = 1;
        $show_kid = 1;

        if($showKidSuitableOnly == 1){
            $stmt = $this->dbConnection->prepare("SELECT * FROM nacha_onet28_occupation_subcluster_with_cluster  WHERE cluster_uuid = :cluster_uuid AND visible = :visible AND show_kid = :show_kid LIMIT 20");
        }else{
            $stmt = $this->dbConnection->prepare("SELECT * FROM nacha_onet28_occupation_subcluster_with_cluster  WHERE cluster_uuid = :cluster_uuid AND visible = :visible AND LIMIT 20");
        }

        $stmt->bindParam(':cluster_uuid', $categoryId);
        $stmt->bindParam(':visible', $visibleValue);
        $stmt->bindParam(':show_kid',$show_kid);

        $stmt->execute();
        $data = $stmt->fetchAll();
        return $data;

    }
    //
    //###########
    //
    public function getPopularKidOccupations(){
        return $this->getPopularOccupations(1);
    }

    public function getPopularOccupations($showKidSuitableOnly=0){

        $visibleValue = 1;
        $show_kid = 1;
        $force_featured_at_onboarding_kid = 1;
        $force_featured_at_onboarding_guardian = 1;

        if($showKidSuitableOnly == 1){
            //
            $stmt = $this->dbConnection->prepare("SELECT * FROM nacha_onet28_occupation_data_with_cluster_subcluster  WHERE force_featured_at_onboarding_kid = :force_featured_at_onboarding_kid AND visible = :visible AND show_kid = :show_kid LIMIT 20");
            $stmt->bindParam(':force_featured_at_onboarding_kid',$force_featured_at_onboarding_kid);
        }else{
            //
            $stmt = $this->dbConnection->prepare("SELECT * FROM nacha_onet28_occupation_data_with_cluster_subcluster  WHERE force_featured_at_onboarding_guardian = :force_featured_at_onboarding_guardian AND visible = :visible AND LIMIT 20");
            $stmt->bindParam(':force_featured_at_onboarding_guardian',$force_featured_at_onboarding_guardian);
        }

        $stmt->bindParam(':visible', $visibleValue);
        $stmt->bindParam(':show_kid',$show_kid);
        $stmt->execute();
        $data = $stmt->fetchAll();
        return $data;
    }
    //
    //
    //###########
    //
    public function getPopularKidOccupationsInCategory($categoryId){
        return $this->getPopularOccupationsInCategory($categoryId,1);
    }

    public function getPopularOccupationsInCategory($categoryId,$showKidSuitableOnly=0){

        $visibleValue = 1;
        $show_kid = 1;
        $force_featured_at_onboarding_kid = 1;
        $force_featured_at_onboarding_guardian = 1;

        if($showKidSuitableOnly == 1){
            $stmt = $this->dbConnection->prepare("SELECT * FROM nacha_onet28_occupation_data_with_cluster_subcluster  WHERE force_featured_at_onboarding_kid = :force_featured_at_onboarding_kid AND cluster_uuid = :cluster_uuid AND visible = :visible AND show_kid = :show_kid LIMIT 20");
            $stmt->bindParam(':force_featured_at_onboarding_kid',$force_featured_at_onboarding_kid);
        }else{
            $stmt = $this->dbConnection->prepare("SELECT * FROM nacha_onet28_occupation_data_with_cluster_subcluster  WHERE force_featured_at_onboarding_guardian = :force_featured_at_onboarding_guardian AND cluster_uuid = :cluster_uuid AND visible = :visible AND LIMIT 20");
            $stmt->bindParam(':force_featured_at_onboarding_guardian',$force_featured_at_onboarding_guardian);
        }

        $stmt->bindParam(':cluster_uuid', $categoryId);
        $stmt->bindParam(':visible', $visibleValue);
        $stmt->bindParam(':show_kid',$show_kid);

        $stmt->execute();
        $data = $stmt->fetchAll();
        return $data;

    }
    //
    //###########
    //
    public function getPopularKidOccupationsInSubcategory($subcategoryId){
        return $this->getPopularOccupationsInSubcategory($subcategoryId,1);
    }

    public function getPopularOccupationsInSubcategory($subcategoryId,$showKidSuitableOnly=0){

        $visibleValue = 1;
        $show_kid = 1;
        $force_featured_at_onboarding_kid = 1;
        $force_featured_at_onboarding_guardian = 1;

        if($showKidSuitableOnly == 1){
            $stmt = $this->dbConnection->prepare("SELECT * FROM nacha_onet28_occupation_data_with_cluster_subcluster  WHERE force_featured_at_onboarding_kid = :force_featured_at_onboarding_kid AND subcluster_uuid = :subcluster_uuid AND visible = :visible AND show_kid = :show_kid LIMIT 20");
            $stmt->bindParam(':force_featured_at_onboarding_kid',$force_featured_at_onboarding_kid);
        }else{
            $stmt = $this->dbConnection->prepare("SELECT * FROM nacha_onet28_occupation_data_with_cluster_subcluster  WHERE force_featured_at_onboarding_guardian = :force_featured_at_onboarding_guardian AND subcluster_uuid = :subcluster_uuid AND visible = :visible AND LIMIT 20");
            $stmt->bindParam(':force_featured_at_onboarding_guardian',$force_featured_at_onboarding_guardian);
        }

        $stmt->bindParam(':subcluster_uuid', $subcategoryId);
        $stmt->bindParam(':visible', $visibleValue);
        $stmt->bindParam(':show_kid',$show_kid);

        $stmt->execute();
        $data = $stmt->fetchAll();
        return $data;

    }
    //
    //###########
    //

}