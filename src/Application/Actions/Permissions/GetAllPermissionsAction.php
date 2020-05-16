<?php
/**
 * Copyright (c) 2020, Theo Crowley. All rights reserved.
 */

declare(strict_types=1);

namespace App\Application\Actions\Permissions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

class GetAllPermissionsAction extends PermissionsAction
{
    protected function action(): Response
    {
        return $this->respondWithData($this->permissionsRepository->getAllPermissions());
    }
}