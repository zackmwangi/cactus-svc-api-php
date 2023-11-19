<?php
declare(strict_types=1);

namespace App\Repository\Activity\Core;

use PDO;

interface CategoryRepositoryInterface
{

    public function __construct(PDO $dbConnection);

}