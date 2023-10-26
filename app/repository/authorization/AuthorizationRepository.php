<?php
declare(strict_types=1);

namespace App\Repository\Authorization;

use App\Repository\Authorization\AuthorizationRepositoryInterface;

use PDO;
use PDO\Exception;

class AuthorizationRepository implements  AuthorizationRepositoryInterface
{
    private $dbConnection;
    private $useRegistrationWhitelist;

    public function __construct(PDO $dbConnection, bool $useRegistrationWhitelist=false){
        $this->dbConnection = $dbConnection;
        $this->useRegistrationWhitelist = $useRegistrationWhitelist;
    }

    public function getPDO(){
        return $this->dbConnection;
    }

    //getBadListedGuardianStatusByEmail
    public function getBadListedGuardianStatusByEmail(String $email){
        //lookup email status in the badlist
        $stmt = $this->dbConnection->prepare("SELECT COUNT(*) FROM guardians_badlist_by_email WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count > 0;
    }


    //getBadListedGuardianByEmail
    //public function getBadlistedGuardianByEmail(String $email){
        //lookup email in the badlist 

    //}
    //createBadListedGuardian
    //deleteBadListedGuardianByEmail

    //useRegistrationWhitelist
    public function useRegistrationWhitelist(){
        return $this->useRegistrationWhitelist;
    }
    //
    //
    //getWhitelistedGuardianByEmail
    public function getWhitelistedRegistrantGuardianExistsByEmail(String $email){
        //lookup email status in the badlist
        $stmt = $this->dbConnection->prepare("SELECT COUNT(*) FROM registrant_whitelist_by_email WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count > 0;
    }
    //createWhitelistedGuardian
    //deleteWhitelistedGuardianByEmail

    public function getFlybyRegistrantGuardianExistsByEmail(String $email){
        $stmt = $this->dbConnection->prepare("SELECT COUNT(*) FROM registrant_flyby WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count > 0;
    }

    public function getFlybyRegistrantGuardianByEmail(String $email){
        $stmt = $this->dbConnection->prepare("SELECT * FROM registrant_flyby WHERE email = :email LIMIT 1");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $data = $stmt->fetch();
        return $data;
    }

    public function logFlybyRegistrantGuardian(array $flybyData){

        //try{
        //
        $sql = "INSERT INTO registrant_flyby (name, email, flyby_at, reminder_1_schedule_for, reminder_2_schedule_for, valid_until, geoinfo_ip_address, geoinfo_country_code, geoinfo_country_name, geoinfo_city, geoinfo_loc, geoinfo_lat, geoinfo_lng) VALUES (
            :name, :email, :flyby_at, :reminder_1_schedule_for, :reminder_2_schedule_for, :valid_until, :geoinfo_ip_address, :geoinfo_country_code, :geoinfo_country_name, :geoinfo_city, :geoinfo_loc, :geoinfo_lat, :geoinfo_lng )";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindValue(":name",$flybyData['name']);
        $stmt->bindValue(":email",$flybyData['email']);
        $stmt->bindValue(":flyby_at",$flybyData['flyby_at']);
        $stmt->bindValue(":reminder_1_schedule_for",$flybyData['reminder_1_schedule_for']);
        $stmt->bindValue(":reminder_2_schedule_for",$flybyData['reminder_2_schedule_for']);
        $stmt->bindValue(":valid_until",$flybyData['valid_until']);
        //
        $stmt->bindValue(":geoinfo_ip_address",$flybyData['geoinfo_ip_address']);
        $stmt->bindValue(":geoinfo_country_code",$flybyData['geoinfo_country_code']);
        $stmt->bindValue(":geoinfo_country_name",$flybyData['geoinfo_country_name']);
        $stmt->bindValue(":geoinfo_city",$flybyData['geoinfo_city']);
        $stmt->bindValue(":geoinfo_loc",$flybyData['geoinfo_loc']);
        $stmt->bindValue(":geoinfo_lat",$flybyData['geoinfo_lat']);
        $stmt->bindValue(":geoinfo_lng",$flybyData['geoinfo_lng']);
        //
        $stmt->execute();
        $count = $stmt->rowCount();
        
        return $count >0;
        //}catch (PDOException $e) {  

            //return false;
        //}
    }

    public function updateFlybyRegistrantGuardian(array $flybyData){
        //
        //try{
        //
        $sql = "UPDATE registrant_flyby SET flyby_at=:flyby_at, flyby_count=:flyby_count WHERE email=:email";
        //
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindValue(":email",$flybyData['email']);
        $stmt->bindValue(":flyby_at",$flybyData['flyby_at']);
        $stmt->bindValue(":flyby_count",$flybyData['flyby_count']);
        $stmt->execute();
        $count = $stmt->rowCount();
        
        return $count >0;
        //}catch (PDOException $e) {  

            //return false;
        //}

    }

    //createPendingGuardian
    //getPendingGuardianByEmail
    //deletePendingGuardianByEmail
    //updatePendingGuardianByEmail

    //createGuardian
        //createGuardianByEmail
        //createGuardianByUuid
        //create Dependants

    public function getGuardianExistsByEmail(String $email){
        //lookup email status in the user list
        $stmt = $this->dbConnection->prepare("SELECT COUNT(*) FROM guardians_by_email WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count > 0;
    }

    //getGuardianByEmail
    public function getGuardianByEmail(String $email){
        //lookup email status in the user list
        $stmt = $this->dbConnection->prepare("SELECT * FROM guardians_by_email WHERE email = :email LIMIT 1");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $data = $stmt->fetch();
        return $data;

    }

    //getGuardianByUuid
    public function getGuardianByUuid(String $guuid){
        //lookup email status in the user list
        $stmt = $this->dbConnection->prepare("SELECT * FROM guardians_by_uuid WHERE guardian_uuid = :guardian_uuid LIMIT 1");
        $stmt->bindParam(':guardian_uuid', $guuid);
        $stmt->execute();
        $data = $stmt->fetch();
        return $data;
    }


    public function updateGuardianLoginInfo(String $gEmail,String $gUuid, String $currentLogin, $previousLogins){
        //
        //decode recent logins upto 100
            //DateTime,Device,IPAddress,

        //Do a light transactional update to all refs

            // By email

            // By Uuid

        //
        $updatedLasttLogin = '';
        $updatedRecentLogins = '';
        //
        //else
        return false;
    }

    //updateGuardian
    //updateGuardianByEmail
    //updateGuardianByUuid
    //
    //
    //deleteGuardianSoft
    //deleteGuardianByEmailSoft
    //deleteGuardianByUuidSoft
    //
    //
    //deleteGuardianHard
    //deleteGuardianByEmailHard
    //deleteGuardianByUuidHard
    
}