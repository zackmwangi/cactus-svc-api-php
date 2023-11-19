<?php
declare(strict_types=1);

namespace App\Repository\Onboarding;

use PDO;

interface OnboardingRepositoryInterface
{
    public function __construct(PDO $dbConnection, bool $useRegistrationWhitelist);

}