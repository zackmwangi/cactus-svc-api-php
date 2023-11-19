<?php
declare(strict_types=1);

namespace App\Repository\Messaging;

use PDO;
use Exception;

class MessagingRepository implements  MessagingRepositoryInterface{
    private $dbConnection;
    

    public function __construct(PDO $dbConnection){
        $this->dbConnection = $dbConnection;
    }

    public function getPDO(){
        return $this->dbConnection;
    }
}