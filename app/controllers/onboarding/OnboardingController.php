<?php
declare(strict_types=1);

namespace App\Controllers\Onboarding;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Repository\Onboarding\Options\OptionsRepository;
use App\Repository\Onboarding\Registrant\RegistrantRepository;


class OnboardingController implements OnboardingControllerInterface
{
    public function __construct(){}

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