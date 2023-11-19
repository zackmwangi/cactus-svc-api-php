<?php
declare(strict_types=1);

namespace App\Repository\Provider\Brand\Flavor;

use PDO;

interface  ProviderBrandFlavorRepositoryInterface
{

    public function __construct(PDO $dbConnection);

}

