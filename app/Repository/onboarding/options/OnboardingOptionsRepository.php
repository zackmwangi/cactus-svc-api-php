<?php
declare(strict_types=1);

namespace App\Repository\Onboarding\Options;

use App\Repository\Onboarding\Options\OnboardingOptionsRepositoryInterface;
//
use App\Repository\Activity\Core\ActivityRepository;
use App\Repository\Activity\Core\SupercategoryRepository;
use App\Repository\Activity\Core\CategoryRepository;
use App\Repository\Activity\Core\SubcategoryRepository;
//
use PDO;
use Exception;

class OnboardingOptionsRepository implements  OnboardingOptionsRepositoryInterface{

    private $dbConnection;
    #
    private $activityRepository;
    private $supercategoryRepository;
    private $categoryRepository;
    private $subcategoryRepository;
    //
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
        $this->activityRepository = new ActivityRepository($this->dbConnection);
        $this->supercategoryRepository = new SupercategoryRepository($this->dbConnection);
        $this->categoryRepository = new CategoryRepository($this->dbConnection);
        $this->subcategoryRepository = new SubcategoryRepository($this->dbConnection);
    }

    public function getPDO(){
        return $this->dbConnection;
    }

    //###############
    //Defaults
    public function getKidSupercategories(){
        return $this->supercategoryRepository->getKidSupercategories();
    }

    public function getSupercategories(){
        return $this->supercategoryRepository->getSupercategories();
    }

    public function getKidCategoriesInSupercategory($supercategoryId){
        return $this->categoryRepository->getKidCategoriesInSupercategory($supercategoryId);
    }

    public function getCategoriesInSupercategory($supercategoryId){
        return $this->categoryRepository->getCategoriesInSupercategory($supercategoryId);
    }
    
    public function getKidSubcategoriesInCategory($categoryId){
        return $this->subcategoryRepository->getKidSubcategoriesInCategory($categoryId);
    }

    public function getSubcategoriesInCategory($categoryId){
        return $this->subcategoryRepository->getSubcategoriesInCategory($categoryId);
        
    }
    //
    //
    public function getPopularKidActivityOptionsInSuperCategory($supercategoryId){
        return $this->activityRepository->getPopularKidActivityOptionsInSuperCategory($supercategoryId);
        //return $this->getPopularActivityOptionsInSuperCategory($supercategoryId,1);
    }

    public function getPopularActivityOptionsInSuperCategory($supercategoryId){
        return $this->activityRepository->getPopularActivityOptionsInSuperCategory($supercategoryId);
    }
    //
    //
    public function getPopularKidActivityOptionsInCategory($categoryId){
        return $this->activityRepository->getPopularKidActivityOptionsInCategory($categoryId);
        //return $this->getPopularActivityOptionsInCategory($categoryId,1);
    }
    public function getPopularActivityOptionsInCategory($categoryId, $showKidSuitableOnly=0){
        return $this->activityRepository->getPopularActivityOptionsInCategory($categoryId);
        
    }
    //
    //
    public function getPopularKidActivityOptionsInSubCategory($subcategoryId){
        return $this->activityRepository->getPopularKidActivityOptionsInSubCategory($subcategoryId);
        //return $this->getPopularActivityOptionsInSubCategory($subcategoryId,1);
    }
    public function getPopularActivityOptionsInSubCategory($subcategoryId){
        return $this->activityRepository->getPopularActivityOptionsInSubCategory($subcategoryId);
       
    }
    //
    //###############
    //Search
    //
    //
    public function getKidActivityOptionsInSuperCategory($supercategoryId){
        return $this->activityRepository->getKidActivityOptionsInSuperCategory($supercategoryId);
    }
    public function getActivityOptionsInSuperCategory($supercategoryId){
        return $this->activityRepository->getActivityOptionsInSuperCategory($supercategoryId);
    }
    //
    //
    public function getKidActivityOptionsInCategory($categoryId){
        return $this->activityRepository->getKidActivityOptionsInCategory($categoryId);
    } 
    public function getActivityOptionsInCategory($categoryId){
        return $this->activityRepository->getActivityOptionsInCategory($categoryId);
    }
    //
    //
    public function getKidActivityOptionsInSubCategory($subcategoryId){
        //return $this->getActivityOptionsInSubCategory($subcategoryId,1);
        return $this->activityRepository->getKidActivityOptionsInSubCategory($subcategoryId);
    }
    public function getActivityOptionsInSubCategory($subcategoryId){
        return $this->activityRepository->getActivityOptionsInSubCategory($subcategoryId);
    }
    //
    //
    public function searchKidActivityOptionsInSuperCategory($supercategoryId){
        return $this->activityRepository->searchKidActivityOptionsInSuperCategory($supercategoryId);
        //return $this->searchActivityOptionsInSuperCategory($supercategoryId,1);
    }
    public function searchActivityOptionsInSuperCategory($supercategoryId){
        return $this->activityRepository->searchActivityOptionsInSuperCategory($supercategoryId);

    }
    //

}
