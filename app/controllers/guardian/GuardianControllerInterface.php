<?php
declare(strict_types=1);

namespace App\Controllers\Guardian;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

interface GuardianControllerInterface
{
   
    public function __construct($db);
    

    public function getUser(Request $request, Response $response, $args);
    
   
}