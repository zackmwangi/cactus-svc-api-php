<?php
declare(strict_types=1);

namespace App\Repository\Activity\Participation;

use PDO;

interface ParticipationHistoryRepositoryInterface
{

    public function __construct(PDO $dbConnection);

}