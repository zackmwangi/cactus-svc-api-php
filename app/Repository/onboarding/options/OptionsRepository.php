<?php
declare(strict_types=1);

namespace App\Repository\Onboarding\Options;

use App\Repository\Onboarding\Options\OnboardingOptionsRepositoryInterface;

use PDO;
use Exception;

class OnboardingOptionsRepository implements  OnboardingOptionsRepositoryInterface{
    private $dbConnection;
    

    public function __construct(PDO $dbConnection){
        $this->dbConnection = $dbConnection;
    }

    public function getPDO(){
        return $this->dbConnection;
    }

}
