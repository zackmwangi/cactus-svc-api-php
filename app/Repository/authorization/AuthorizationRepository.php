<?php
declare(strict_types=1);

namespace App\Repository\Authorization;

use App\Repository\Authorization\AuthorizationRepositoryInterface;

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
    
}