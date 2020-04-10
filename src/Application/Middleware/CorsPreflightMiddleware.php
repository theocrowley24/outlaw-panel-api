<?php
declare(strict_types=1);

namespace App\Application\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;


class CorsPreflightMiddleware implements Middleware {
    public function process(Request $request, RequestHandler $handler): ResponseInterface
    {
        /*
        if ($request->getMethod() !== "OPTIONS") {
            return $handler->handle($request);
        }
        */

        $_response = $handler->handle($request);

        $_response = $_response->withAddedHeader('access-control-allow-headers', 'uid');

        return $_response;
    }
}