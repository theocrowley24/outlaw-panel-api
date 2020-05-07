<?php
declare(strict_types=1);

namespace App\Application\Actions\Permissions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

class UserHasPermission extends PermissionsAction
{
    protected function action(): Response
    {
        $parsedBody = $this->request->getParsedBody();
        $userId = $parsedBody["userId"];
        $permissionId = $parsedBody["permissionId"];

        $hasPermission = $this->permissionsRepository->userHasPermission($userId, $permissionId);

        return $this->respondWithData(array("hasPermission" => $hasPermission));
    }
}