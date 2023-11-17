<?php
declare(strict_types=1);

namespace App\Controllers\Streaming;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
//use App\Repository\

interface StreamingControllerInterface
{
    //public function __construct(array $jwtSettings, OnboardingRepository $onboardingRepository);
    public function __construct();

}