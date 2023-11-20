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

    public function getAuthProfileForidTokenPayload(array $validatedUserIdTokePayload){}

    public function getAuthprofileExistsById(String $id){}

    public function getAuthprofileExistsByEmail(String $emailAddress){}

    public function getAuthprofileRowById(String $id){}

    public function getAuthprofileRowByEmail(String $emailAddress){}

    public function createAuthprofileResponseMapFromRow($authprofileEntryRow){}

    public function updateLastLoginsById(
        String $id
        //auth_profile
        //main identity table
    ){}
    
    public function updateLastLoginsByEmail(
        String $emailAddress
        //auth_profile
        //main identity table
    ){}

}