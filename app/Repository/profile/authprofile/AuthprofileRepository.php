<?php
declare(strict_types=1);

namespace App\Repository\Profile\Authprofile;

use PDO;

class AuthprofileRepository implements AuthprofileRepositoryInterface{
    private $dbConnection;

    public function __construct(PDO $dbConnection){
        $this->dbConnection = $dbConnection;
    }
}

