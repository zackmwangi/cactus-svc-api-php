<?php
declare(strict_types=1);

namespace App\Repository\Profile\Identity;

use PDO;

interface IdentityRepositoryInterface
{

    public function __construct(PDO $dbConnection);

}

