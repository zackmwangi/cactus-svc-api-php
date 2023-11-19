<?php
declare(strict_types=1);

namespace App\Repository\Shop;

use PDO;
use Exception;

class ShopRepository implements  ShopRepositoryInterface{
    private $dbConnection;
    

    public function __construct(PDO $dbConnection){
        $this->dbConnection = $dbConnection;
    }

    public function getPDO(){
        return $this->dbConnection;
    }
}