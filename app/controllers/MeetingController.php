<?php

namespace App\controllers;

use Illuminate\Database\Capsule\Manager;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class MeetingController
{
    private $container;
    private $logger;
    private $db;
    protected $meeting_table;
    protected $participant_table;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
        $this->logger = $container->get(LoggerInterface::class);
        $this->db = $container->get(Manager::class);
        $this->meeting_table = $this->db->table('event');
        $this->participant_table = $this->db->table('event_user');
    }

    public function get($request, $response, $args): Response {
        $event_id = $args['id'];
        $data = $this->meeting_table->where('event_id', $event_id)->first();
        $data = json_decode(json_encode($data), true);
        $data["participants"] = $this->participant_table->select('user_id', 'isValidate')->where('event_id', $event_id)->get();
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
        $data = $this->meeting_table->get();
        $payload = json_encode($data, JSON_UNESCAPED_UNICODE);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function post($request, $response, $args): Response
    {
        $json = $request->getBody();
        $data = json_decode($json, true);
        $meeting_id = $this->meeting_table->insertGetId($data, "event_id");
        $status = 201;
        $data = array("event_id" => $meeting_id);
        if ($meeting_id == null) {
            $status = 404;
            $data = array("message" => "error: not found");
        }
        $payload = json_encode($data, JSON_UNESCAPED_UNICODE);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function delete($request, $response, $args): Response {
        $event_id = $args['id'];
        $isSuccess = $this->participant_table->where('event_id', $event_id)->delete();
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
        $event_id = $args['id'];
        $data = json_decode($request->getBody(), true);
        $isSuccess = $this->participant_table->where('event_id', $event_id)->update($data);
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