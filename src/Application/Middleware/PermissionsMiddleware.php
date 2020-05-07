<?php
declare(strict_types=1);

namespace App\Application\Middleware;

use Slim\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

use App\Domain\PermissionsRepository;

class PermissionsMiddleware implements Middleware {
    private $permissionsRepository;

    public function __construct(PermissionsRepository $permissionsRepository) {
        $this->permissionsRepository = $permissionsRepository;
    }

    public function process(Request $request, RequestHandler $handler): ResponseInterface
    {
        $route = $request->getUri()->getPath();

        $permissionId = $this->permissionsRepository->getPermissionId($route);
        //$userId = intval($request->getHeader("uid")[0]);
        $userId = $_COOKIE['uid'];
        $rankId = intval($this->permissionsRepository->getRankId(intval($userId)));

        if ($this->permissionsRepository->rankHasPermission($rankId, $permissionId)) {
            return $handler->handle($request);
        }

        return (new Response())->withStatus(403);
    }
}