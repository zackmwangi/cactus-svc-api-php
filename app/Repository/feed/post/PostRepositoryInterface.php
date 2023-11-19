
<?php
declare(strict_types=1);

namespace App\Repository\Feed\Post;

use PDO;

interface FeedPostRepositoryInterface
{
    public function __construct(PDO $dbConnection);

}