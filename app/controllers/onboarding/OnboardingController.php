<?php
declare(strict_types=1);

namespace App\Controllers\Onboarding;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Controllers\Onboarding\OnboardingControllerInterface;
use App\Repository\Onboarding\OnboardingRepository;

class OnboardingController implements OnboardingControllerInterface
{
    //private $onboardingRepository ;
    //Registrant by Auth provider
    //Options

    public function __construct(){
        //$this->onboardingRepository = $onboardingRepository ;
    }

    //Ondemand listing for empathy
    //list popular for applicant - kid (age, gender, locality)
    
    //list popular for applicant  - (age, gender, locality)
    //public function getPopularActivitiesAll(){}

    //list popular for applicant/kid per cat/subcat
    //
    //###########


    //search for activities in supercat
    public function searchActivitiesInSupercat(){}
    //
    //list activities
    //
    //list activities for Category
    public function getActivitiesInCcat(){}
    //list activities for subcategory
    public function getActivitiesInSubcat(){}
    //feedback
    public function gatherFlybyFeedback(){}
    //register new application
    public function registerApplicant(){}

}