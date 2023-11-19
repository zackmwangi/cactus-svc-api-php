<?php
declare(strict_types=1);

namespace App\Repository\Shop\Brand\Flavor;

use PDO;

interface  BrandFlavorRepositoryInterface
{

    public function __construct(PDO $dbConnection);

}

