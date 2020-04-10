<?php
declare(strict_types=1);

namespace App\Application\Actions\Permissions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

class GetAllPermissionGroups extends PermissionsAction
{
    protected function action(): Response
    {
        return $this->respondWithData($this->permissionsRepository->getAllPermissionGroups());
    }
}