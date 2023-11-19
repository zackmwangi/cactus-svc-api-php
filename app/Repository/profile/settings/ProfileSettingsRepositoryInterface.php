<?php
declare(strict_types=1);

namespace App\Repository\Profile\Settings;

use PDO;

interface ProfileSettingsRepositoryInterface
{

    public function __construct(PDO $dbConnection);

}

