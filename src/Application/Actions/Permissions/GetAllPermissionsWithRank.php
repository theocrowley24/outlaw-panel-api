<?php
/**
 * Copyright (c) 2020, Theo Crowley. All rights reserved.
 */

declare(strict_types=1);

namespace App\Application\Actions\Permissions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

class GetAllPermissionsWithRank extends PermissionsAction
{
    protected function action(): Response
    {
        $parsedBody = $this->request->getParsedBody();
        $rankId = intval($parsedBody['id']);

        return $this->respondWithData($this->permissionsRepository->getAllPermissionsWithRank($rankId));
    }
}