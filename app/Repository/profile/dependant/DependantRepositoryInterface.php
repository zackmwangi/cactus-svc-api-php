<?php
declare(strict_types=1);

namespace App\Repository\Profile\Dependant;

use PDO;

interface DependantRepositoryInterface
{

    public function __construct(PDO $dbConnection);

}

