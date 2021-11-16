<?php

namespace App\actions;

use App\actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Illuminate\Database\Capsule\Manager;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

class LoginAction extends Action
{
    protected function action(): Response
    {
        // TODO: Implement action() method.
        $payload = $this->request->getBody();
        $data = json_decode($payload, true);
        $email = $data['email'];
        $password = $data['password'];
        $user_table = $this->db->table('user');
        $user = $user_table->where('email', $email)->where('password', $password)->get();
        if ($user == null) return $this->respondWithData(array("message" => "not found"));
        return $this->respondWithData(json_decode(json_encode($user), true));
    }
}