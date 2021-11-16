<?php

namespace App\controllers;

use Illuminate\Database\Capsule\Manager;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use App\actions\Action;

class UserController
{
    private $container;
    private $logger;
    private $db;
    protected $user_table;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
        $this->logger = $container->get(LoggerInterface::class);
        $this->db = $container->get(Manager::class);
        $this->user_table = $this->db->table('user');
    }

//    public function get($request, $response, $args): Response {
//        $action = new class() extends Action {
//
//            protected function action(): Response
//            {
//                $user_id = $this->resolveArg('id');
//                return $this->respondWithData($this->db->table('user')->get($user_id));
//            }
//        };
//        return $action::class;
//    }

    public function get($request, $response, $args): Response {
        $user_id = $args['id'];
        $data = $this->user_table->where('user_id', $user_id)->first();
        $status = 200;

        if ($data == null) {
            $status = 404;
            $payload = json_encode(array("message" => "error: id not found or invalid"));
        } else $payload = json_encode($data, JSON_UNESCAPED_UNICODE);

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json')
            ->withStatus($status);
    }

    public function getAll($request, $response, $args): Response {
        $data = $this->user_table->get();
        $payload = json_encode($data, JSON_UNESCAPED_UNICODE);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function post($request, $response, $args): Response
    {
        $json = $request->getBody();
        $data = json_decode($json, true);
        $user_id = $this->user_table->insertGetId($data, "user_id");
        $status = 201;
        $data = array("user_id" => $user_id);
        if ($user_id == null) {
            $status = 404;
            $data = array("message" => "error: not found");
        }
        $payload = json_encode($data, JSON_UNESCAPED_UNICODE);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function delete($request, $response, $args): Response {
        $user_id = $args['id'];
        $isSuccess = $this->user_table->where('user_id', $user_id)->delete();
        $status = 200;
        $data = array("message" => "sucess");
        if (!$isSuccess) {
            $status = 404;
            $payload = json_encode(array("message" => "error: id not found or invalid"));
        } else $payload = json_encode($data, JSON_UNESCAPED_UNICODE);

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json')
            ->withStatus($status);
    }

    public function update($request, $response, $args): Response {
        $user_id = $args['id'];
        $data = json_decode($request->getBody(), true);
        $isSuccess = $this->user_table->where('user_id', $user_id)->update($data);
        $status = 200;
        $data = array("message" => "sucess");
        if (!$isSuccess) {
            $status = 404;
            $payload = json_encode(array("message" => "error: id not found or invalid"));
        } else $payload = json_encode($data, JSON_UNESCAPED_UNICODE);

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json')
            ->withStatus($status);
    }

}