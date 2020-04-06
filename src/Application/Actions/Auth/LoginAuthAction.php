<?php

namespace App\Application\Actions\Auth;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

class LoginAuthAction extends AuthAction {
    protected function action(): Response {
        $parsedBody = $this->request->getParsedBody();
        $username = $parsedBody['username'];
        $password = $parsedBody['password'];

        if (!$username || !$password) {
            $this->respondWithData("Failed");
        }

        if (!$this->authRepository->login($username, $password)) {
            return $this->respondWithData("Failed to login");
        }

        $_SESSION['token'] = $this->authRepository->getToken($username);

        return $this->respondWithData($this->authRepository->getToken($username));
    }
}