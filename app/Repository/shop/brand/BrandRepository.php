<?php
declare(strict_types=1);

namespace App\Repository\Shop\Brand;

use PDO;

class BrandRepository implements BrandRepositoryInterface{
    private $dbConnection;

    public function __construct(PDO $dbConnection){
        $this->dbConnection = $dbConnection;
    }

    public function addBrand($uuid){}

    public function getBrandByUuid($uuid){}

    public function updateBrand($uuid){}

    public function deleteBrand($uuid){}

}

