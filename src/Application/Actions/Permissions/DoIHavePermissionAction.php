<?php
/**
 * Copyright (c) 2020, Theo Crowley. All rights reserved.
 */

declare(strict_types=1);

namespace App\Application\Actions\Permissions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

class DoIHavePermissionAction extends PermissionsAction
{
    protected function action(): Response
    {
        $parsedBody = $this->request->getParsedBody();
        $permissionId = intval($parsedBody["permissionId"]);
        $userId = intval($_COOKIE["uid"]);

        return $this->respondWithData($this->permissionsRepository->doIHavePermission($userId, $permissionId));
    }
}