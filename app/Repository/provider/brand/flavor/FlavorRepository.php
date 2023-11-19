<?php
declare(strict_types=1);

namespace App\Repository\Provider\Brand\Flavor;

use PDO;

class ProviderBrandFlavorRepository implements ProviderBrandFlavorRepositoryInterface{
    private $dbConnection;

    public function __construct(PDO $dbConnection){
        $this->dbConnection = $dbConnection;
    }

    public function addProviderBrandFlavor($uuid){}

    public function getProviderBrandFlavorByUuid($uuid){}

    public function updateProviderBrandFlavor($uuid){}

    public function deleteProviderBrandFlavor($uuid){}

}

