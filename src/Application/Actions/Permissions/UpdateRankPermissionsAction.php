<?php
/**
 * Copyright (c) 2020, Theo Crowley. All rights reserved.
 */

declare(strict_types=1);

namespace App\Application\Actions\Permissions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

class UpdateRankPermissionsAction extends PermissionsAction
{
    protected function action(): Response
    {
        $parsedBody = $this->request->getParsedBody();
        $rankId = $parsedBody['id'];
        $permissions = $parsedBody['permissions'];

        // Resets permissions
        $this->permissionsRepository->removeAllPermissions(intval($rankId));

        // Adds all new permissions in
        foreach ($permissions as $permissionId) {
            $this->permissionsRepository->addPermissionToRank($permissionId, intval($rankId));
        }

        return $this->respondWithData("Rank permissions updated");
    }
}