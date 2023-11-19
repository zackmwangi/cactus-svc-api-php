<?php
declare(strict_types=1);

namespace App\Repository\Shop\Product;

use PDO;
use Exception;

class ProductRepository implements  ProductRepositoryInterface{
    private $dbConnection;
    

    public function __construct(PDO $dbConnection){
        $this->dbConnection = $dbConnection;
    }

    public function getPDO(){
        return $this->dbConnection;
    }
}