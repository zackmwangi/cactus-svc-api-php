<?php
declare(strict_types=1);

namespace App\Repository\Profile\Authprofile;

use PDO;

interface AuthprofileAppleRepositoryInterface extends AuthProfileProviderRepositoryInterface
{

    public function __construct(PDO $dbConnection, bool $useRegistrationWhitelist);

}