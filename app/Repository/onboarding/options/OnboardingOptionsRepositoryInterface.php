<?php
declare(strict_types=1);

namespace App\Repository\Onboarding\Options;

use PDO;

interface OnboardingOptionsRepositoryInterface
{

    public function __construct(PDO $dbConnection);

}