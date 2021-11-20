<?php

require_once __DIR__ . '/../controllers/UserController.php';

use App\actions\LoginAction;
use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use App\controllers\UserController;
use App\controllers\RoomController;
use App\controllers\MeetingController;

return function (App $app) {

    $app->options('/', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response, $args) {
        $response->getBody()->write('Success!');
        return $response;
    });

    $app->post('/login', LoginAction::class);

    $app->post('/user',UserController::class . ':post');
    $app->delete('/user/{id}', UserController::class . ':delete');
    $app->get('/user/all', UserController::class . ':getAll');
    $app->get('/user/{id}',UserController::class . ':get');
    $app->put('/user/{id}', UserController::class . ':update');
    $app->patch('/user/{id}', UserController::class . ':update');

    $app->post('/room',RoomController::class . ':post');
    $app->delete('/room/{id}', RoomController::class . ':delete');
    $app->get('/room/all', RoomController::class . ':getAll');
    $app->get('/room/{id}',RoomController::class . ':get');
    $app->put('/room/{id}', RoomController::class . ':update');
    $app->patch('/room/{id}', RoomController::class . ':update');

    $app->post('/meeting', MeetingController::class . ':post');
    $app->delete('/meeting/{id}', MeetingController::class . ':delete');
    $app->get('/meeting/all', MeetingController::class . ':getAll');
    $app->get('/meeting/{id}', MeetingController::class . ':get');
    $app->put('/meeting/{id}', MeetingController::class . ':update');
    $app->patch('/meeting/{id}', MeetingController::class . ':update');

    //$app->get('/meeting/{id}/participant', MeetingController::class . ':get');

//    $app->post('/v2/login', LoginAction::class);
//
//    $app->group('/v2/api_admin', function (Group $group) {
//        //$group->get('/');
//    });

};