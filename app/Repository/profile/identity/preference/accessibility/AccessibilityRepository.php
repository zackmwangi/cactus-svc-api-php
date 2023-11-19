<?php
declare(strict_types=1);

namespace App\Repository\Profile\Identity\Preference\Accessibility;

use PDO;

class AccessibilityPreferenceRepository implements AccessibilityPreferenceRepositoryInterface{
    private $dbConnection;

    public function __construct(PDO $dbConnection){
        $this->dbConnection = $dbConnection;
    }

    public function addAccessibility($uuid){}

    public function getAccessibilityByUuid($uuid){}

    public function updateAccessibility($uuid){}

    public function deleteAccessibility($uuid){}

}

