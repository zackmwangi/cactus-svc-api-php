<?php
declare(strict_types=1);

namespace App\Repository\Shop\Brand;

use PDO;

interface BrandRepositoryInterface
{

    public function __construct(PDO $dbConnection);

}

