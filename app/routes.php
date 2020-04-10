<?php
declare(strict_types=1);

use App\Application\Actions\Auth\LoginAuthAction;
use App\Application\Actions\Auth\LogoutAuthAction;
use App\Application\Actions\Permissions\CreateNewRankAction;
use App\Application\Actions\Permissions\GetAllPermissionGroups;
use App\Application\Actions\Permissions\GetAllPermissionsAction;
use App\Application\Actions\Permissions\GetAllPermissionsWithRank;
use App\Application\Actions\Permissions\GetAllRankPermissionsAction;
use App\Application\Actions\Permissions\GetAllRanksAction;
use App\Application\Actions\Permissions\UpdateRankAction;
use App\Application\Actions\Permissions\UpdateRankPermissionsAction;
use App\Application\Actions\Players\GetAllPlayersAction;
use App\Application\Actions\Players\GetPlayerByIdAction;

use App\Application\Middleware\AuthMiddleware;
use App\Application\Middleware\PermissionsMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->group('/auth', function (Group $group) {
        $group->post('/login', LoginAuthAction::class);
        $group->post('/logout', LogoutAuthAction::class)->add(AuthMiddleware::class);
    });//->add(AuthMiddleware::class);

    $app->group('/players', function(Group $group) {
        $group->get('/getAllPlayers', GetAllPlayersAction::class);
        $group->post('/getPlayerById', GetPlayerByIdAction::class);
    })->add(AuthMiddleware::class)
        ->add(PermissionsMiddleware::class);

    $app->group('/permissions', function(Group $group) {
        $group->post('/createNewRank', CreateNewRankAction::class);
        $group->post('/updateRank', UpdateRankAction::class);
        $group->post('/updateRankPermissions', UpdateRankPermissionsAction::class);
        $group->post('/getAllRankPermissions', GetAllRankPermissionsAction::class);
        $group->post('/getAllPermissionsWithRank', GetAllPermissionsWithRank::class);

        $group->get('/getAllPermissions', GetAllPermissionsAction::class);
        $group->get('/getAllRanks', GetAllRanksAction::class);
        $group->get('/getAllPermissionGroups', GetAllPermissionGroups::class);
    });

    /**
     * Catch-all route to serve a 404 Not Found page if none of the routes match
     * NOTE: make sure this route is defined last
     */
    $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
        throw new HttpNotFoundException($request);
    });
};
