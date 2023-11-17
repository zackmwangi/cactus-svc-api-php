<?php
declare(strict_types=1);

namespace App\Middleware\Authorization;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

interface OnboardingAuthMiddlewareInterface
{
    
    public function __construct(array $jwtSettings);
    
    public function __invoke(Request $request, RequestHandler $handler);
}