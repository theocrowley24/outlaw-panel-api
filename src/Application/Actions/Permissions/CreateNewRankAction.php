<?php
/**
 * Copyright (c) 2020, Theo Crowley. All rights reserved.
 */

declare(strict_types=1);

namespace App\Application\Actions\Permissions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

class CreateNewRankAction extends PermissionsAction
{
    protected function action(): Response
    {
        $parsedBody = $this->request->getParsedBody();
        $name = $parsedBody['name'];
        $permissions = $parsedBody['permissions'];


        $rankId = $this->permissionsRepository->createNewRank($name);

        if ($permissions == null) {
            return $this->respondWithData("Rank created without permissions");
        }

        foreach ($permissions as $permissionId) {
            $this->permissionsRepository->addPermissionToRank($permissionId, $rankId);
        }


        return $this->respondWithData("Rank created");
    }
}