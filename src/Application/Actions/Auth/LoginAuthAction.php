<?php
declare(strict_types=1);

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

        $_SESSION['token'] = $this->authRepository->getToken();

        /*
        $data['uid'] = $this->authRepository->getUid($username);
        $data['accessToken'] = $this->authRepository->getToken();
        */

        setcookie("authToken", (string)$_SESSION['token'],time()+3600, "/");
        setcookie("uid", (string)$this->authRepository->getUid($username),time()+3600, "/");

        return $this->respondWithData("Logged in");
    }
}