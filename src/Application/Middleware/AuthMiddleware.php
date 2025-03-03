<?php
/**
 * Copyright (c) 2020, Theo Crowley. All rights reserved.
 */

declare(strict_types=1);

namespace App\Application\Middleware;

use Slim\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

use App\Domain\AuthRepository;

class AuthMiddleware implements Middleware
{
    private $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function process(Request $request, RequestHandler $handler): ResponseInterface
    {
        //$accessToken = $request->getHeader('accessToken')[0];
        $accessToken = $_COOKIE['authToken'];

        if (!$this->authRepository->verifyToken($accessToken)) {
            $response = new Response();
            return $response->withStatus(403);
        }

        return $handler->handle($request);
    }
}