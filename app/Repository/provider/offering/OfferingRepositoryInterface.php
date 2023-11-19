<?php
declare(strict_types=1);

namespace App\Repository\Provider\Offering;

use PDO;

interface OfferingRepositoryInterface
{

    public function __construct(PDO $dbConnection);

}

