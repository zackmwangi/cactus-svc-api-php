<?php
declare(strict_types=1);

namespace App\Repository\Onboarding\Registrant;

use PDO;
use Exception;

class RegistrantAppleRepository implements  RegistrantAppleRepositoryInterface, RegistrantProviderRepositoryInterface
{
    private $dbConnection;
    private $useRegistrationEmailWhitelist;
    

    public function __construct(PDO $dbConnection, bool $useRegistrationEmailWhitelist=false){
        $this->dbConnection = $dbConnection;
        $this->useRegistrationEmailWhitelist = $useRegistrationEmailWhitelist;
    }

    public function getPDO(){
        return $this->dbConnection;
    }

    //##############endregion public function getRegistrantExistsById();
    public function addRegistrant(array $registrantData){}

    public function getRegistrantProfileForIdTokenPayload(array $validatedUserIdTokePayload){
        
    }

    public function updateRegistrantFlyby(array $registrantData){}

    public function getRegistrantExistsById(String $id){}
         
    public function getRegistrantExistsByEmail(String $email){}

    public function getRegistrantRowById(String $id){}

    public function getRegistrantRowByEmail(String $email){}

    //public function createRegistrantResponseMapFromRow($authprofileEntryRow){}

    public function updateLastFlybyById(
        String $id
        //auth_profile
        //main identity table
    ){}

    public function updateLastFlybyByEmail(
        String $email
        //auth_profile
        //main identity table
    ){}

}
