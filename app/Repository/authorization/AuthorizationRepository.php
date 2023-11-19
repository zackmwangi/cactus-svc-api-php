<?php
declare(strict_types=1);

namespace App\Repository\Authorization;

use PDO;
//use PDO\Exception;
use Exception;

class AuthorizationRepository implements  AuthorizationRepositoryInterface
{
    private $dbConnection;
    private $useRegistrationCountryWhitelist;
    private $useRegistrationEmailWhitelist;
    #
    public function __construct(PDO $dbConnection, bool $useRegistrationCountryWhitelist=false, bool $useRegistrationEmailWhitelist=false){
        $this->dbConnection = $dbConnection;
        $this->useRegistrationCountryWhitelist = $useRegistrationCountryWhitelist;
        $this->useRegistrationEmailWhitelist = $useRegistrationEmailWhitelist;
    }

    public function getPDO(){
        return $this->dbConnection;
    }

    //Existing user
    public function getAuthProfileForProviderAndTokenId($provider,$tokenId){
        //return
        //Existing user profile
        //or
        //Registrant profile for new registration
    }
    //
    public function getAuthProfileForTokenIdGoogle($tokenId){
        
    }

    public function getAuthProfileForTokenIdApple($tokenId){}

    //public function getAuthProfileForTokenIdFacebook($tokenId){}

    //New Registrant
    public function getRegistrantAuthProfileForProviderAndTokenId($provider,$tokenId){}

    public function getRegistrantAuthProfileForTokenIdGoogle($tokenId){}

    public function getRegistrantAuthProfileForTokenIdApple($tokenId){}

    //public function getRegistrantAuthProfileForTokenIdFacebook($tokenId){}
    //
    //

    
    
}