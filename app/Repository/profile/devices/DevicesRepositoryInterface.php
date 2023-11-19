<?php
declare(strict_types=1);

namespace App\Repository\Profile\Device;

use PDO;

interface DeviceRepositoryInterface
{

    public function __construct(PDO $dbConnection);

}

