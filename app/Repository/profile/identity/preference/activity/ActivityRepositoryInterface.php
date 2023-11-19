<?php
declare(strict_types=1);

namespace App\Repository\Profile\Identity\Preference\Activity;

use PDO;

interface ActivityPreferenceRepositoryInterface
{

    public function __construct(PDO $dbConnection);

}

