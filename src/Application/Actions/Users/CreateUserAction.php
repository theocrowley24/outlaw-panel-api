<?php
/**
 * Copyright (c) 2020, Theo Crowley. All rights reserved.
 */

declare(strict_types=1);

namespace App\Application\Actions\Users;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

class CreateUserAction extends UsersAction
{
    protected function action(): Response
    {
        $parsedBody = $this->request->getParsedBody();

        if ($this->usersRepository->createUser($parsedBody["data"])) {
            return $this->generateResponse(200,array("message" => "User created."));
        } else {
            return $this->generateResponse(200,array("message" => "Error when creating user."));
        }
    }
}