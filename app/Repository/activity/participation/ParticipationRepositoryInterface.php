<?php
declare(strict_types=1);

namespace App\Repository\Activity\Participation;

use PDO;

interface ParticipationRepositoryInterface
{

    public function __construct(PDO $dbConnection);

}