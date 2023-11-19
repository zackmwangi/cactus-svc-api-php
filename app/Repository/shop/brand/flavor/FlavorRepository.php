<?php
declare(strict_types=1);

namespace App\Repository\Shop\Brand\Flavor;

use PDO;

class BrandFlavorRepository implements BrandFlavorRepositoryInterface{
    private $dbConnection;

    public function __construct(PDO $dbConnection){
        $this->dbConnection = $dbConnection;
    }

    public function addBrandFlavor($uuid){}

    public function getBrandFlavorByUuid($uuid){}

    public function updateBrandFlavor($uuid){}

    public function deleteBrandFlavor($uuid){}

}

