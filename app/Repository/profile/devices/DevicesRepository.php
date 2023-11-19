<?php
declare(strict_types=1);

namespace App\Repository\Profile\Device;

use PDO;

class DeviceRepository implements DeviceRepositoryInterface{
    private $dbConnection;

    public function __construct(PDO $dbConnection){
        $this->dbConnection = $dbConnection;
    }

    public function addDevice($uuid){}

    public function getDeviceByUuid($uuid){}

    public function updateDevice($uuid){}

    public function deleteDevice($uuid){}

}

