<?php
declare(strict_types=1);

namespace App\Repository\Onboarding\Registrant;

use App\Repository\Onboarding\Registrant\OnboardingRegistrantRepositoryInterface;

use PDO;
use Exception;

class OnboardingRegistrantRepository implements  OnboardingRegistrantRepositoryInterface{
    private $dbConnection;
    

    public function __construct(PDO $dbConnection){
        $this->dbConnection = $dbConnection;
    }

    public function getPDO(){
        return $this->dbConnection;
    }

}
