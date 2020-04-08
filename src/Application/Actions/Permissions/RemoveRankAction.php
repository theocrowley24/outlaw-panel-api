<?php
declare(strict_types=1);

namespace App\Application\Actions\Permissions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

class RemoveRankAction extends PermissionsAction
{
    protected function action(): Response
    {
        $parsedBody = $this->request->getParsedBody();
        $rankId = $parsedBody['id'];

        $this->permissionsRepository->deleteRank($rankId);

        return $this->response;
    }
}