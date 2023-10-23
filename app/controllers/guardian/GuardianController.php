<?php
declare(strict_types=1);

namespace App\Controllers\Guardian;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class GuardianController implements GuardianControllerInterface
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getUser(Request $request, Response $response, $args)
    {
        $userId = $args['id'];

        // Replace the following logic with your own user retrieval mechanism, e.g., fetching user data from a database.
        // For demonstration purposes, we use a simple array of users.
        $user = $this->getUserById($userId);

        if ($user) {
            $data = $user;
            $payload = json_encode($data);
            $response->getBody()->write($payload);
            return $response->withStatus(200);
            
        } else {
            $data = ['error' => 'User not found'];
            $payload = json_encode($data);
            $response->getBody()->write($payload);
            return $response->withStatus(404);
            
        }
    }

    //AddUser

    //Get by id
    private function getUserById($userId)
    {
        // Example: Retrieving user from an array
        $users = [
            1 => ['id' => 1, 'username' => 'user1', 'email' => 'user1@example.com'],
            2 => ['id' => 2, 'username' => 'user2', 'email' => 'user2@example.com'],
            // Add more user data as needed
        ];

        return isset($users[$userId]) ? $users[$userId] : null;
    }
}