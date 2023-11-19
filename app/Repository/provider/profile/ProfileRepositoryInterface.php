<?php
declare(strict_types=1);

namespace App\Repository\Provider\Profile;

use PDO;

interface ProviderProfileRepositoryInterface
{

    public function __construct(PDO $dbConnection);

}

