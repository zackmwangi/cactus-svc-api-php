<?php
declare(strict_types=1);

namespace App\Controllers\Messaging;

use Kreait\Firebase\Contract\Messaging;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class MessagingController implements MessagingControllerInterface
{
    public function __construct(){}
}