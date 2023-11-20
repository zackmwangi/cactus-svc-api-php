<?php
declare(strict_types=1);

namespace App\Repository\Provider\Offering\History;

use PDO;

class OfferingHistoryRepository implements OfferingHistoryRepositoryInterface{
    private $dbConnection;

    public function __construct(PDO $dbConnection){
        $this->dbConnection = $dbConnection;
    }

    public function addOffering($uuid){}

    public function getOfferingByUuid($uuid){}

    public function updateOffering($uuid){}

    public function deleteOffering($uuid){}

}

