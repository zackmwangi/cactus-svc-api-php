<?php
declare(strict_types=1);

namespace App\Repository\Profile\Authprofile;

use PDO;

class AuthprofileAppleRepository implements AuthprofileAppleRepositoryInterface, AuthProfileProviderRepositoryInterface
{
    private $dbConnection;

    public function __construct(PDO $dbConnection, bool $useRegistrationWhitelist){
        $this->dbConnection = $dbConnection;
    }

    public function getAuthprofileExistsById(){}

    public function getAuthprofileExistsByEmail(){}

    public function getAuthprofileRowById(){}

    public function getAuthprofileRowByEmail(){}

    public function createAuthprofileResponseMapFromRow($authprofileEntryRow){}

    public function updateLastLoginsById(
        //auth_profile
        //main identity table
    ){}
    
    public function updateLastLoginsByEmail(
        //auth_profile
        //main identity table
    ){}

}