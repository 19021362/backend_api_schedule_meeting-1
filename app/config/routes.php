<?php

require_once __DIR__ . '/../controllers/UserController.php';

use App\actions\LoginAction;
use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use Illuminate\Database\Capsule\Manager;
use App\controllers\UserController;
use App\controllers\RoomController;
use App\controllers\MeetingController;

return function (App $app) {

    $app->get('/', function (Request $request, Response $response, $args) {
        if ( ! class_exists('MeetingController')) {
            $response->getBody()->write('Success!');
        } else {
            $response->getBody()->write('Failed!');
        }
        return $response;
    });

//    $app->get('/user/{id}', function (Request $request, Response $response, $args) {
//        $id = $args['id'];
//        $response->getBody()->write("Hello $id");
//        return $response;
//    });


//        die('There is no hope!');
//

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

};