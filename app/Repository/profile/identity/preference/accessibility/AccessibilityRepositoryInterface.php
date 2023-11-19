<?php
declare(strict_types=1);

namespace App\Repository\Profile\Identity\Preference\Accessibility;

use PDO;

interface AccessibilityPreferenceRepositoryInterface
{

    public function __construct(PDO $dbConnection);

}

