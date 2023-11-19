<?php
declare(strict_types=1);

namespace App\Repository\Bucketlist;

use PDO;

interface BucketlistRepositoryInterface
{
    public function __construct(PDO $dbConnection);

}