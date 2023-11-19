<?php
declare(strict_types=1);

namespace App\Repository\Feed;

use PDO;

interface FeedRepositoryInterface
{
    public function __construct(PDO $dbConnection);

}