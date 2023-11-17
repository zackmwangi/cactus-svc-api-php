<?php
declare(strict_types=1);

namespace App\Controllers\Healthz;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class HealthzController implements HealthzControllerInterface
{
    public function __construct(){}
}