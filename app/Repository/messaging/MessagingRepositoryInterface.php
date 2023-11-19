<?php
declare(strict_types=1);

namespace App\Repository\Messaging;

use PDO;

interface MessagingRepositoryInterface
{
    public function __construct(PDO $dbConnection);

}