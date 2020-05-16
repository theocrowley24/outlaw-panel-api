<?php
declare(strict_types=1);

namespace App\Application\Actions\Users;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

class UpdateUserAction extends UsersAction
{
    protected function action(): Response
    {
        $parsedBody = $this->request->getParsedBody();
        $userId = $parsedBody['id'];
        $data = $parsedBody['data'];

        $this->usersRepository->updateUser($userId, $data);


        return $this->generateResponse(200, array("message" => "Updated user successfully"));
    }
}