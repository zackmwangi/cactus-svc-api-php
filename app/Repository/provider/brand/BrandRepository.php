<?php
declare(strict_types=1);

namespace App\Repository\Provider\ProviderBrand;

use PDO;

class ProviderBrandRepository implements ProviderBrandRepositoryInterface{
    private $dbConnection;

    public function __construct(PDO $dbConnection){
        $this->dbConnection = $dbConnection;
    }

    public function addProviderBrand($uuid){}

    public function getProviderBrandByUuid($uuid){}

    public function updateProviderBrand($uuid){}

    public function deleteProviderBrand($uuid){}

}

