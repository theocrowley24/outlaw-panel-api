<?php
declare(strict_types=1);

namespace App\Application\Actions\Permissions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

class GetAllRankPermissionsAction extends PermissionsAction
{
    protected function action(): Response
    {
        $parsedBody = $this->request->getParsedBody();
        $rankId = $parsedBody['id'];

        return $this->respondWithData($this->permissionsRepository->getRankPermissionIds($rankId));
    }
}