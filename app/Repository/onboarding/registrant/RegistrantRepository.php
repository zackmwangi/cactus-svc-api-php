<?php
declare(strict_types=1);

namespace App\Repository\Onboarding\Registrant;

use PDO;
use Exception;

class RegistrantRepository implements  RegistrantRepositoryInterface
{
    private $dbConnection;
    //private $useRegistrationCountryWhitelist;
    //
    private $useRegistrationEmailWhitelist;
    private $authProvider;

    public function __construct(PDO $dbConnection, bool $useRegistrationEmailWhitelist=false){
        $this->dbConnection = $dbConnection;
        //
        //TODO: Add country whitelist
        //$this->useRegistrationCountryWhitelist = $useRegistrationCountryWhitelist;
        $this->useRegistrationEmailWhitelist = $useRegistrationEmailWhitelist;

        //##############
        /*
        switch($this->authProvider){
            case 'google':
            //$this->authProviderClass = new Auth

            //break;
            case 'apple';
            case 'facebook';
            case 'linkedin';
            case 'github';
            case 'microsoft';
            case 'x';
            default:
            //return $response->withStatus(400);
            break;
        }
        */
        //##############
    }

    public function getPDO(){
        return $this->dbConnection;
    }

    //##############endregion public function getRegistrantExistsById();

    public function getRegistrantExistsById(){}
         
    public function getRegistrantExistsByEmail(){}

    public function getRegistrantRowById(){}

    public function getRegistrantRowByEmail(){}

    public function createRegistrantResponseMapFromRow($authprofileEntryRow){}

    public function updateLastFlybyById(
        //auth_profile
        //main identity table
    ){}

    public function updateLastFlybyByEmail(
        //auth_profile
        //main identity table
    ){}

}
