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
