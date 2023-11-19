<?php
declare(strict_types=1);

namespace App\Repository\Shop\Product;

use PDO;

interface ProductRepositoryInterface
{
    public function __construct(PDO $dbConnection);

}