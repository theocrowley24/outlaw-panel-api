<?php
/**
 * Copyright (c) 2020, Theo Crowley. All rights reserved.
 */

declare(strict_types=1);

namespace App\Application\Actions\Users;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

class GetAllUsersAction extends UsersAction
{
    protected function action(): Response
    {
        return $this->respondWithData($this->usersRepository->getAllUsers());
    }
}