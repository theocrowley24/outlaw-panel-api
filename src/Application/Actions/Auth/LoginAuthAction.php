<?php
/**
 * Copyright (c) 2020, Theo Crowley. All rights reserved.
 */

declare(strict_types=1);

namespace App\Application\Actions\Auth;

use Slim\Psr7\Response as Psr7Response;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

class LoginAuthAction extends AuthAction
{
    protected function action(): Response
    {
        $parsedBody = $this->request->getParsedBody();
        $username = $parsedBody['username'];
        $password = $parsedBody['password'];

        if (!$username || !$password) {
            $response = new Psr7Response();
            $response->withStatus(401);
            $response->getBody()->write(json_encode(array("message" => "Failed to login")));
            return $response;
        }

        if (!$this->authRepository->login($username, $password)) {
            $response = new Psr7Response();
            $response->withStatus(401);
            $response->getBody()->write(json_encode(array("message" => "Failed to login")));
            return $response;
        }

        if ($this->authRepository->login($username, $password)) {
            $_SESSION['token'] = $this->authRepository->getToken();

            setcookie("authToken", (string)$_SESSION['token'], time() + 3600, "/");
            setcookie("uid", (string)$this->authRepository->getUid($username), time() + 3600, "/");

            return $this->respondWithData("Logged in");
        }

        $response = new Psr7Response();
        $response->withStatus(401);
        $response->getBody()->write(json_encode(array("message" => "Failed to login")));
        return $response;
    }
}