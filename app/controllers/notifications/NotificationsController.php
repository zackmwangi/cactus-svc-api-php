<?php
declare(strict_types=1);

namespace App\Controllers\Notifications;

use Kreait\Firebase\Contract\Messaging;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class NotificationsController implements NotificationsControllerInterface
{
    public function __construct(){}
}