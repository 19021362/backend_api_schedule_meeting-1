<?php

namespace App\controllers;

use Illuminate\Database\Capsule\Manager;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class RoomController
{
    private $container;
    private $logger;
    private $db;
    protected $room_table;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
        $this->logger = $container->get(LoggerInterface::class);
        $this->db = $container->get(Manager::class);
        $this->room_table = $this->db->table('room');
    }

    public function get($request, $response, $args): Response {
        $room_id = $args['id'];
        $data = $this->room_table->where('room_id', $room_id)->first();
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
        $data = $this->room_table->get();
        $payload = json_encode($data, JSON_UNESCAPED_UNICODE);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function post($request, $response, $args): Response
    {
        $json = $request->getBody();
        $data = json_decode($json, true);
        $room_id = $this->room_table->insertGetId($data, "room_id");
        $status = 201;
        $data = array("room_id" => $room_id);
        if ($room_id == null) {
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
        $isSuccess = $this->room_table->where('user_id', $user_id)->delete();
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
        $room_id = $args['id'];
        $data = json_decode($request->getBody(), true);
        $isSuccess = $this->user_table->where('user_id', $room_id)->update($data);
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