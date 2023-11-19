<?php
declare(strict_types=1);

namespace App\Repository\Profile\Authprofile;

use PDO;

interface AuthprofileRepositoryInterface
{

    public function __construct(PDO $dbConnection);

}

