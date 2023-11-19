<?php
declare(strict_types=1);

namespace App\Repository\Accessibility;

use PDO;

interface AccessibilityRepositoryInterface
{

    public function __construct(PDO $dbConnection);

}

