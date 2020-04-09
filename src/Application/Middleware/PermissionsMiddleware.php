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
        // Get the root
        $route = $request->getUri()->getPath();

/*
        $test = new Response();
        $test->getBody()->write("ROUTE: " . $route);
        return $test;*/

        // Get the permission id for that root
        $permissionId = $this->permissionsRepository->getPermissionId($route);
        // Get the users group (id) and then the rank id
        $userId = intval($request->getHeader("uid")[0]);
        $rankId = intval($this->permissionsRepository->getRankId($userId));
        // Check if rank_permissions table contains the permission id for that rank id (and not inactive)
        if ($this->permissionsRepository->rankHasPermission($rankId, $permissionId)) {
            return $handler->handle($request);
        }

        return (new Response())->withStatus(403);
        // If it does then continue
        // Else return with 403
    }
}