<?php
declare(strict_types=1);

namespace App\Repository\Profile\Authprofile;

use PDO;

class AuthprofileGoogleRepository implements AuthprofileGoogleRepositoryInterface, AuthProfileProviderRepositoryInterface
{
    private $dbConnection;

    public function __construct(PDO $dbConnection, bool $useRegistrationWhitelist){
        $this->dbConnection = $dbConnection;
    }

    public function getAuthProfileForIdTokenPayload(array $validatedUserIdTokePayload){
        $email = $validatedUserIdTokePayload['email'];
        return $this->getAuthprofileRowByEmail($email);
    }

    public function getAuthprofileExistsById(String $id){}

    public function getAuthprofileExistsByEmail(String $email){}

    public function getAuthprofileRowById(String $id){}

    //public function getAuthprofileRowById(){}

    public function getAuthprofileRowByEmail(String $email){
        $stmt = $this->dbConnection->prepare("SELECT * FROM auth_profile_google WHERE email = :email LIMIT 1");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $data = $stmt->fetch();
        return $data;
    }

    public function createAuthprofileResponseMapFromRow($authprofileEntryRow){
        //return data
        return false;
    }

    public function updateLastLoginsById(
        String $id
        //auth_profile
        //main identity table
    ){}
    
    public function updateLastLoginsByEmail(
        String $email
        //auth_profile
        //main identity table
    ){}

}