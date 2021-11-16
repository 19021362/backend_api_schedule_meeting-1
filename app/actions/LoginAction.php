<?php

namespace App\actions;

use Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface as Response;

class LoginAction extends Action
{
    protected function action(): Response
    {

        // TODO: Implement action() method.
        $data = $this->request->getParsedBody();
        $email = $data['email'];
        $password = $data['password'];
        $user_table = $this->db->table('user');
        $user = $user_table->select('user_id', 'name', 'title', 'email', 'isAdmin')->where('email', $email)->where('password', $password)->get();
        if ($user == null) return $this->respondWithData(array("message" => "not found"));
        $jwt = JWT::encode(json_encode($user), 'secret', 'HS256');
        return $this->respondWithData(array('token' => $jwt))->withStatus(200);
    }
}