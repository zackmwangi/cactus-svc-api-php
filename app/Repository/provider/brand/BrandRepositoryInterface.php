<?php
declare(strict_types=1);

namespace App\Repository\Provider\ProviderBrand;

use PDO;

interface ProviderBrandRepositoryInterface
{

    public function __construct(PDO $dbConnection);

}

