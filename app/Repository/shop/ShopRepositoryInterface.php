<?php
declare(strict_types=1);

namespace App\Repository\Shop;

use PDO;

interface ShopRepositoryInterface
{
    public function __construct(PDO $dbConnection);

}