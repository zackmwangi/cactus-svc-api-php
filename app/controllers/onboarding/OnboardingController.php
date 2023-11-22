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
    public function searchActivitiesInSupercat(Request $request, Response $response, array $args){
        //

        //
    }

    //Hooby
    public function searchActivitiesInSupercatHobby(Request $request, Response $response, array $args){
        //
        
        //
        //$allPostVars = $request->$_POST;
        //$allPostVars = (array)$request->getParsedBody();
        //$allPostVars = $request->post();
        //
        //var_dump($allPostVars);
        //
        //error_log($allPostVars['searchType']);
        //error_log($allPostVars['searchValue']);

        $topResults = [];
        //
        for($i=1;$i<=100;$i++){
            $item = [
                "uuid"=>"uuid-H".$i, "name"=>"Hobby ".$i
            ];
            //
            $topResults[] = $item;

        }

        //
        //
        /*
        $item1 = ["uuid"=>"uuid-H1", "name"=>"Hobby 1"];
        $item2 = ["uuid"=>"uuid-H2", "name"=>"Hobby 2"];
        $item3 = ["uuid"=>"uuid-H3", "name"=>"Hobby 3"];
        $item4 = ["uuid"=>"uuid-H4", "name"=>"Hobby 4"];
        $item5 = ["uuid"=>"uuid-H5", "name"=>"Hobby 5"];
        //
        //
        $searchResponseMap["topResults"] = [
            $item1,
            $item2,
            $item3,
            $item4,
            $item5,
        ];
        */
       $searchResponseMap["topResults"] = $topResults;
        $searchResponseMap["relevantResults"] = [];

        //
        $responsePayload = json_encode($searchResponseMap);
        $response->getBody()->write($responsePayload);
        return $response->withStatus(200);
        //
    }

    //Sport
    public function searchActivitiesInSupercatSport(Request $request, Response $response, array $args){
        //
        $item1 = ["uuid"=>"uuid-S1", "name"=>"Sport 1"];
        $item2 = ["uuid"=>"uuid-S2", "name"=>"Sport 2"];
        $item3 = ["uuid"=>"uuid-S3", "name"=>"Sport 3"];
        $item4 = ["uuid"=>"uuid-S4", "name"=>"Sport 4"];
        $item5 = ["uuid"=>"uuid-S5", "name"=>"Sport 5"];
        //
        //
        $searchResponseMap["topResults"] = [
            $item1,
            $item2,
            $item3,
            $item4,
            $item5,
        ];

        $searchResponseMap["relevantResults"] = [];

        //
        $responsePayload = json_encode($searchResponseMap);
        $response->getBody()->write($responsePayload);
        return $response->withStatus(200);
    }

    //Topic
    public function searchActivitiesInSupercatTopic(Request $request, Response $response, array $args){
        //
        $item1 = ["uuid"=>"uuid-T1", "name"=>"Topic 1"];
        $item2 = ["uuid"=>"uuid-T2", "name"=>"Topic 2"];
        $item3 = ["uuid"=>"uuid-T3", "name"=>"Topic 3"];
        $item4 = ["uuid"=>"uuid-T4", "name"=>"Topic 4"];
        $item5 = ["uuid"=>"uuid-T5", "name"=>"Topic 5"];
        //
        //
        $searchResponseMap["topResults"] = [
            $item1,
            $item2,
            $item3,
            $item4,
            $item5,
        ];

        $searchResponseMap["relevantResults"] = [];

        //
        $responsePayload = json_encode($searchResponseMap);
        $response->getBody()->write($responsePayload);
        return $response->withStatus(200);

        //

        //
    }

    //Career
    public function searchActivitiesInSupercatCareer(Request $request, Response $response, array $args){

        //
        $item1 = ["uuid"=>"uuid-CR1", "name"=>"Career 1"];
        $item2 = ["uuid"=>"uuid-CR2", "name"=>"Career 2"];
        $item3 = ["uuid"=>"uuid-CR3", "name"=>"Career 3"];
        $item4 = ["uuid"=>"uuid-CR4", "name"=>"Career 4"];
        $item5 = ["uuid"=>"uuid-CR5", "name"=>"Career 5"];
        //
        //
        $searchResponseMap["topResults"] = [
            $item1,
            $item2,
            $item3,
            $item4,
            $item5,
        ];

        $searchResponseMap["relevantResults"] = [];

        //
        $responsePayload = json_encode($searchResponseMap);
        $response->getBody()->write($responsePayload);
        return $response->withStatus(200);

        //
    }

    //Charity
    public function searchActivitiesInSupercatCharity(Request $request, Response $response, array $args){
        //
        $item1 = ["uuid"=>"uuid-CH1", "name"=>"Charity 1"];
        $item2 = ["uuid"=>"uuid-CH2", "name"=>"Charity 2"];
        $item3 = ["uuid"=>"uuid-CH3", "name"=>"Charity 3"];
        $item4 = ["uuid"=>"uuid-CH4", "name"=>"Charity 4"];
        $item5 = ["uuid"=>"uuid-CH5", "name"=>"Charity 5"];
        //
        //
        $searchResponseMap["topResults"] = [
            $item1,
            $item2,
            $item3,
            $item4,
            $item5,
        ];

        $searchResponseMap["relevantResults"] = [];

        //
        $responsePayload = json_encode($searchResponseMap);
        $response->getBody()->write($responsePayload);
        return $response->withStatus(200);

        //

        //
    }

    //get popular for child
        //
    public function getPopularActivitiesForKid(Request $request, Response $response, array $args){
        //
        //Age

        //Gender

        //Location
        //
    }
        //
    public function getPopularActivitiesForGuardian(Request $request, Response $response, array $args){
        //
        //Age

        //Gender

        //Location
    }
        //
    //get popular for adult


    //list activities
    //
    //list activities for Category
    public function getActivitiesInCat(Request $request, Response $response, array $args){
        //
        //return kid or guardian version depending on request
        //
    }
        public function getActivitiesInCatForKid(Request $request, Response $response, array $args){
            //
            //
        }
        public function getActivitiesInCatForGuardian(Request $request, Response $response, array $args){
            //
            //
        }
    //
    //list activities for subcategory
    public function getActivitiesInSubcat(Request $request, Response $response, array $args){}
        public function getActivitiesInSubcatForKid(Request $request, Response $response, array $args){}
        public function getActivitiesInSubcatForGuardian(Request $request, Response $response, array $args){}
    //
    //feedback
    public function gatherFlybyFeedback(Request $request, Response $response, array $args){}
    //register new application
    public function registerApplicant(Request $request, Response $response, array $args){}

}