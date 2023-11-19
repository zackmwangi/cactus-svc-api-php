<?php
declare(strict_types=1);

namespace App\Repository\Onboarding\Registrant;

use PDO;

interface RegistrantAppleRepositoryInterface
{

    public function __construct(PDO $dbConnection, bool $useRegistrationWhitelist);

}