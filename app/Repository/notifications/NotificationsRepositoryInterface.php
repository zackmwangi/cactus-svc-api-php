<?php
declare(strict_types=1);

namespace App\Repository\Notifications;

use PDO;

interface NotificationsRepositoryInterface
{
    public function __construct(PDO $dbConnection);

}