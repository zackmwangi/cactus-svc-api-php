<?php
declare(strict_types=1);

namespace App\Repository\Onboarding\Registrant;

use PDO;

interface RegistrantProviderRepositoryInterface
{

    //public function __construct(PDO $dbConnection);

    public function getRegistrantExistsById();

    public function getRegistrantExistsByEmail();

    public function getRegistrantRowById();

    public function getRegistrantRowByEmail();

    public function createRegistrantResponseMapFromRow($authprofileEntryRow);

    public function updateLastFlybyById(
        //auth_profile
        //main identity table
    );

    public function updateLastFlybyByEmail(
        //auth_profile
        //main identity table
    );

    
}