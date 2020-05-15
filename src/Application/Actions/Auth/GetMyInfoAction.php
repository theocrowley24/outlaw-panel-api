<?php
declare(strict_types=1);

namespace App\Application\Actions\Auth;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

class GetMyInfoAction extends AuthAction
{
    protected function action(): Response
    {
        $userId = $_COOKIE['uid'];

        return $this->respondWithData($this->authRepository->getMyInfo(intval($userId)));
    }
}