<?php
declare(strict_types=1);

namespace App\Controllers\Authorization;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Firebase\JWT\JWT;

use App\Repository\Authorization\AuthorizationRepository;

interface AuthorizationControllerInterface
{
    public function __construct(array $jwtSettings, AuthorizationRepository $authorizationRepository);

    public function authorizeIdtoken(Request $request, Response $response, array $args);

}