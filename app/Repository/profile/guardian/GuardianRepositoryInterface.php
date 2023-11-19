<?php
declare(strict_types=1);

namespace App\Repository\Profile\Guardian;

use PDO;

interface GuardianRepositoryInterface
{

    public function __construct(PDO $dbConnection);

}

