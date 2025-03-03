<?php
/**
 * Copyright (c) 2020, Theo Crowley. All rights reserved.
 */

declare(strict_types=1);

namespace App\Application\Actions\Auth;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

class LogoutAuthAction extends AuthAction
{
    //TODO Add cookie support
    protected function action(): Response
    {
        $parsedBody = $this->request->getParsedBody();
        $uid = $parsedBody['uid'];
        $accessToken = $parsedBody['accessToken'];

        $actualToken = $this->authRepository->getToken();

        if (strcmp($accessToken, $actualToken) == 0) {
            $this->authRepository->logout();
            return $this->respondWithData("Logged out");
        }


        return $this->response->withStatus(403);
    }
}