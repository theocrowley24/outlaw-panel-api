<?php
declare(strict_types=1);

namespace App\Application\Actions\Auth;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

class VerifyTokenAction extends AuthAction
{
    protected function action(): Response
    {
        $parsedBody = $this->request->getParsedBody();

        return $this->respondWithData($this->authRepository->verifyToken($parsedBody['accessToken']));
    }
}