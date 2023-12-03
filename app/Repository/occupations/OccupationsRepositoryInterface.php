<?php
declare(strict_types=1);

namespace App\Repository\Occupations;

use PDO;

interface OccupationsRepositoryInterface
{

    public function __construct(PDO $dbConnection);

}