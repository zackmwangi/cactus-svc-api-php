<?php
declare(strict_types=1);

namespace App\Repository\Onboarding\Registrant;

use PDO;

interface RegistrantProviderRepositoryInterface
{

    //public function __construct(PDO $dbConnection);
    public function addRegistrant(array $registrantData);

    public function updateRegistrantFlyby(array $registrantData);

    public function getRegistrantProfileForIdTokenPayload(array $validatedUserIdTokePayload);

    public function getRegistrantExistsById(String $id);

    public function getRegistrantExistsByEmail(String $email);

    public function getRegistrantRowById(String $id);

    public function getRegistrantRowByEmail(String $email);

    //public function createRegistrantResponseMapFromRow($authprofileEntryRow);

    public function updateLastFlybyById(
        String $id
        //auth_profile
        //main identity table
    );

    public function updateLastFlybyByEmail(
        String $email
        //auth_profile
        //main identity table
    );

    
}