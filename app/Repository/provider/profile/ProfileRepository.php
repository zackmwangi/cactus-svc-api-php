<?php
declare(strict_types=1);

namespace App\Repository\Provider\Profile;

use PDO;

class ProviderProfileRepository implements ProviderProfileRepositoryInterface{
    private $dbConnection;

    public function __construct(PDO $dbConnection){
        $this->dbConnection = $dbConnection;
    }

    public function addProviderProfile($uuid){}

    public function getProviderProfileByUuid($uuid){}

    public function updateProviderProfile($uuid){}

    public function deleteProviderProfile($uuid){}

}

