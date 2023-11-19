<?php
declare(strict_types=1);

namespace App\Repository\Notifications;

use PDO;
use Exception;

class NotificationsRepository implements  NotificationsRepositoryInterface{
    private $dbConnection;
    

    public function __construct(PDO $dbConnection){
        $this->dbConnection = $dbConnection;
    }

    public function getPDO(){
        return $this->dbConnection;
    }
}