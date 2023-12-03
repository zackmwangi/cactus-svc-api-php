<?php
declare(strict_types=1);

namespace App\Repository\Onboarding\Registrant;

use Ramsey\Uuid\Uuid;

use PDO;
use Exception;

class RegistrantGoogleRepository implements  RegistrantGoogleRepositoryInterface, RegistrantProviderRepositoryInterface
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
    public function addRegistrant(array $registrantData){
        try{

        //$registrantUuid = Uuid::uuid4()->toString();

        //printf("registrant UUID is: ", $registrantUuid);
        //error_log("registrant UUID is: ".$registrantUuid);

        //
        $sql = "INSERT INTO nacha_core_registrant_flyby_google (fullname, email, flyby_time, reminder_1_schedule_time, reminder_2_schedule_time, valid_until_time, geoinfo_ip_address, geoinfo_country_code, geoinfo_country_name, geoinfo_city, geoinfo_loc, geoinfo_lat, geoinfo_lng, created_time) VALUES (
            :fullname, :email, :flyby_time, :reminder_1_schedule_time, :reminder_2_schedule_time, :valid_until_time, :geoinfo_ip_address, :geoinfo_country_code, :geoinfo_country_name, :geoinfo_city, :geoinfo_loc, :geoinfo_lat, :geoinfo_lng, :created_time )";
        //
        $stmt = $this->dbConnection->prepare($sql);
        //
        $stmt->bindValue(":fullname",$registrantData['fullname']);
        $stmt->bindValue(":email",$registrantData['email']);
        //
        $stmt->bindValue(":geoinfo_ip_address",$registrantData['geoinfo_ip_address']);
        $stmt->bindValue(":geoinfo_country_code",$registrantData['geoinfo_country_code']);
        $stmt->bindValue(":geoinfo_country_name",$registrantData['geoinfo_country_name']);
        $stmt->bindValue(":geoinfo_city",$registrantData['geoinfo_city']);
        $stmt->bindValue(":geoinfo_loc",$registrantData['geoinfo_loc']);
        $stmt->bindValue(":geoinfo_lat",$registrantData['geoinfo_lat']);
        $stmt->bindValue(":geoinfo_lng",$registrantData['geoinfo_lng']);
        //
        $stmt->bindValue(":flyby_time",$registrantData['flyby_time']);
        $stmt->bindValue(":reminder_1_schedule_time",$registrantData['reminder_1_schedule_time']);
        $stmt->bindValue(":reminder_2_schedule_time",$registrantData['reminder_2_schedule_time']);
        $stmt->bindValue(":valid_until_time",$registrantData['valid_until_time']);
        $stmt->bindValue(":created_time",$registrantData['created_time']);
        //
        $stmt->execute();
        $count = $stmt->rowCount();

        return $count >0;

        }catch (\PDOException $e) {  
            error_log( $e->getMessage());
            return false;
        }


    }

    public function updateRegistrantFlyby(array $registrantData){
        
        try{
        //
        $sql = "UPDATE nacha_core_registrant_flyby_google SET ";
        $sql .= "flyby_time=:flyby_time,";
        $sql .= "flyby_count=:flyby_count,";

        $sql .= "geoinfo_ip_address=:geoinfo_ip_address,";
        $sql .= "geoinfo_country_code=:geoinfo_country_code,";
        $sql .= "geoinfo_country_name=:geoinfo_country_name,";
        $sql .= "geoinfo_city=:geoinfo_city,";
        $sql .= "geoinfo_loc=:geoinfo_loc,";
        $sql .= "geoinfo_lat=:geoinfo_lat,";
        $sql .= "geoinfo_lng=:geoinfo_lng";

        $sql .= " WHERE email=:email";
        //
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindValue(":email",$registrantData['email']);
        $stmt->bindValue(":flyby_time",$registrantData['flyby_time']);
        $stmt->bindValue(":flyby_count",$registrantData['flyby_count']);
        //
        $stmt->bindValue(":geoinfo_ip_address",$registrantData['geoinfo_ip_address']);
        $stmt->bindValue(":geoinfo_country_code",$registrantData['geoinfo_country_code']);
        $stmt->bindValue(":geoinfo_country_name",$registrantData['geoinfo_country_name']);
        $stmt->bindValue(":geoinfo_city",$registrantData['geoinfo_city']);
        $stmt->bindValue(":geoinfo_loc",$registrantData['geoinfo_loc']);
        $stmt->bindValue(":geoinfo_lat",$registrantData['geoinfo_lat']);
        $stmt->bindValue(":geoinfo_lng",$registrantData['geoinfo_lng']);
        //
        $stmt->execute();
        $count = $stmt->rowCount();
        
        return $count >0;
        }catch (\PDOException $e) {  
            error_log( $e->getMessage());
            return false;
        }
    }

    public function getRegistrantProfileForIdTokenPayload(array $validatedUserIdTokePayload){
        $email = $validatedUserIdTokePayload['email'];
        return $this->getRegistrantRowByEmail($email);
    }

    public function getRegistrantExistsById(String $id){}
         
    public function getRegistrantExistsByEmail(String $email){}

    public function getRegistrantRowById(String $id){}

    public function getRegistrantRowByEmail(String $email){
        $stmt = $this->dbConnection->prepare("SELECT * FROM nacha_core_registrant_flyby_google WHERE email = :email LIMIT 1");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $data = $stmt->fetch();
        return $data;
    }

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
