<?php
declare(strict_types=1);

namespace App\Controllers\Onboarding;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
//
use App\Repository\Onboarding\OnboardingRepository;

interface OnboardingControllerInterface
{
    public function __construct(OnboardingRepository $onboardingRepository);

   

}