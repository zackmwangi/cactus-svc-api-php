<?php
declare(strict_types=1);

namespace App\Repository\Authorization;

use PDO;

interface AuthorizationRepositoryInterface
{

    public function __construct(PDO $dbConnection, bool $useRegistrationWhitelist);

}