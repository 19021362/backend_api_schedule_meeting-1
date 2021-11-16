<?php

namespace App\middlewares;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthenticationMiddleware implements MiddlewareInterface
{
    public function process(Request $request, RequestHandlerInterface $handler): Response
    {
        // TODO: Implement process() method.
        $jwt = $request->getAttribute('Authorization');
        $payload = JWT::decode($jwt, new Key('secret', 'HS256'));
        $request->withQueryParams();
        $response = $handler->handle($request);
        return $response->withHeader('Access-Control-Allow-Origin', 'http://localhost:3000');
    }
}