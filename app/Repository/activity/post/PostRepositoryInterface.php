<?php
declare(strict_types=1);

namespace App\Repository\Activity\Post;

use PDO;

interface ActivityPostRepositoryInterface
{

    public function __construct(PDO $dbConnection);

}