<?php
declare(strict_types=1);

namespace App\Repository\Provider\Offering;

use PDO;

interface OfferingHistoryRepositoryInterface
{

    public function __construct(PDO $dbConnection);

}

