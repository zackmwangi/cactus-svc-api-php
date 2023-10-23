<?php
declare(strict_types=1);

namespace App\Models;

class UserModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    
}
