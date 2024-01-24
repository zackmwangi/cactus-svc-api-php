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

    public function getActivityOptions (Request $request, Response $response, array $args){
        //sleep(1);
        //
        //
        // age
        // gender
        // location
        //
        //

        $topResults = [];

        //
        $supercatResultsHobby = [];
        //Hobby
            $supercatResultsHobby['isAccess'] = false;
            //id
            $supercatResultsHobby['uuid'] = '4bad52c6-8118-11ee-8fd4-67bd7e40c726';
            //name
            $supercatResultsHobby['name'] = 'Hobbies and interests';
            //description
            //$supercatResultsHobby['description'] = '';


            //Landing Heading
            $supercatResultsHobby['supercatLandingHeaderText'] = '';
            //Landing SubHeading
            $supercatResultsHobby['supercatLandingDescriptorText'] = '';
            //
            //
            //Search Explainer header
            $supercatResultsHobby['searchExplainerHeaderText'] = 'Adapted for toddlers';
            //Search Explainer subHeader
            $supercatResultsHobby['searchExplainerDescriptorText'] = 'These activities are labelled as suitable for toddlers.';
            //
            //
            $supercatResultsHobby['search_hint_text'] = 'Find activities';
            $supercatResultsHobby['hint_text'] = 'Find activities';
            //Search Heading Featured
            $supercatResultsHobby['header_text_popular_all'] = 'Featured for toddlers';
            //Search SubHeading Categories
            $supercatResultsHobby['header_text_popular_cats'] = 'Popular for younglings';
            //
            //
            //Options
                //CatFeatured
                $pop1 = array();
                //
                $pop1['uuid'] = 'x1';
                $pop1['name'] = 'Water play';
                $pop2['uuid'] = 'x2';
                $pop2['name'] = 'Roll and Crawl';
                $pop3['uuid'] = 'x3';
                $pop3['name'] = 'Visual - contrast';
                //
                $supercatResultsHobby['popular_in_all'] = [
                    $pop1,
                    $pop2
                ];
                //Cat Others Featured
                //######################
                $pop4['uuid'] = 'x4';
                $pop4['name'] = 'Sights and visual';
                $pop5['uuid'] = 'x5';
                $pop5['name'] = 'Touch and feel';
                $pop6['uuid'] = 'x6';
                $pop6['name'] = 'Sound and hearing';
                //
                //
                $cat1 = array();
                $cat1['uuid'] = 'c1';
                $cat1['name'] = 'Sensory play';
                $cat1['popular_in_cat'] = [
                    $pop4,
                    $pop5,
                    $pop6
                ];
                //######################
                $pop7['uuid'] = 'x7';
                $pop7['name'] = 'Playful laughter';

                $pop8['uuid'] = 'x8';
                $pop8['name'] = 'Skin-to-skin contact';

                $pop9['uuid'] = 'x9';
                $pop9['name'] = 'Giggles and baby talk';
                //
                //
                $cat2 = array();
                $cat2['uuid'] = 'c2';
                $cat2['name'] = 'Bonding and Connection';
                $cat2['popular_in_cat'] = [
                    $pop7,
                    $pop8,
                    $pop9
                ];

                //######################


                $supercatResultsHobby['popular_in_cats'] = [$cat1,$cat2];
                    //Subcats
            //
            //max allowed K
            $supercatResultsHobby['supercatMaxSelections'] = 5;
            //min allowed K
            $supercatResultsHobby['supercatMinSelections'] = 1;
            
            //min allowed G
            //$supercatResultsHobby['supercatMinSelectionsG'] = '';
            //max allowed G
            //$supercatResultsHobby['supercatMaxSelectionsG'] = '';



        //Sport
        $supercatResultsSport = [];
        $supercatResultsSport['isAccess'] = false;

        //Career
        $supercatResultsCareer = [];
        $supercatResultsCareer['isAccess'] = false;

        //Charity
        $supercatResultsCharity = [];
        $supercatResultsCharity['isAccess'] = false;

        //Accessibility
        $supercatResultsAccessibility = [];
        $supercatResultsAccessibility['isAccess'] = true;

        //
        $topResults['4bad52c6-8118-11ee-8fd4-67bd7e40c726'] = $supercatResultsHobby;
        /*
        $topResults['56280bba-8118-11ee-8fd4-67bd7e40c726'] = $supercatResultsSport;
        $topResults['6a26cb1a-8118-11ee-8fd4-67bd7e40c726'] = $supercatResultsCareer;
        $topResults['70f2e28a-8118-11ee-8fd4-67bd7e40c726'] = $supercatResultsCharity ;
        $topResults['9eae9cb8-8b6e-11ee-9d9c-bde544a2630a'] = $supercatResultsAccessibility;
        */
        //
        $optionsResponseMap['topResults'] = $topResults;
        $responsePayload = json_encode($optionsResponseMap);
        $response->getBody()->write($responsePayload);
        //
        return $response->withStatus(200);
        //return $response->withStatus(400);
    }

    //Hooby
    public function searchActivitiesInSupercatHobby(Request $request, Response $response, array $args){
        //
        //
        //$allPostVars = $request->$_POST;
        $allPostVars = (array)$request->getParsedBody();
        //$allPostVars = $request->post();
        //
        //die(var_dump($allPostVars));
        //die(var_dump($_POST['searchType']));
        //
        //error_log($allPostVars['searchType']);
        //error_log($allPostVars['searchValue']);
        //
        //
        $topResults = [];
        $relevantResults = [];
        //
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
        $searchResponseMap["relevantResults"] = $relevantResults;

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