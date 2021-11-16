<?php

namespace App\middlewares;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CorsMiddleware implements MiddlewareInterface
{

    public function process(Request $request, RequestHandlerInterface $handler): Response
    {
        // TODO: Implement process() method.
        $response = $handler->handle($request);
        return $response->withHeader('Access-Control-Allow-Origin', 'http://localhost:3000');
    }
}