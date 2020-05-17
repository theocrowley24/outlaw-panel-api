<?php
/**
 * Copyright (c) 2020, Theo Crowley. All rights reserved.
 */

declare(strict_types=1);

use App\Application\Actions\Auth\GetMyInfoAction;
use App\Application\Actions\Auth\LoginAuthAction;
use App\Application\Actions\Auth\LogoutAuthAction;
use App\Application\Actions\Auth\VerifyTokenAction;
use App\Application\Actions\Permissions\CreateNewRankAction;
use App\Application\Actions\Permissions\GetAllPermissionGroups;
use App\Application\Actions\Permissions\GetAllPermissionsAction;
use App\Application\Actions\Permissions\GetAllPermissionsWithRank;
use App\Application\Actions\Permissions\GetAllRankPermissionsAction;
use App\Application\Actions\Permissions\GetAllRanksAction;
use App\Application\Actions\Permissions\GetUserRankAction;
use App\Application\Actions\Permissions\UpdateRankAction;
use App\Application\Actions\Permissions\UpdateRankPermissionsAction;
use App\Application\Actions\Permissions\UserHasPermission;
use App\Application\Actions\Players\GetAllPlayersAction;
use App\Application\Actions\Players\GetPlayerByIdAction;

use App\Application\Actions\Players\UpdatePlayer;
use App\Application\Actions\Users\CreateUserAction;
use App\Application\Actions\Users\GetAllUsersAction;
use App\Application\Actions\Users\GetUserByIdAction;
use App\Application\Actions\Users\UpdateUserAction;
use App\Application\Actions\Vehicles\GetAllVehiclesAction;
use App\Application\Middleware\AuthMiddleware;
use App\Application\Middleware\PermissionsMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Exception\HttpNotFoundException;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->group('/auth', function (Group $group) {
        $group->post('/login', LoginAuthAction::class);
        $group->get('/verify', VerifyTokenAction::class);
        $group->get('/getMyInfo', GetMyInfoAction::class);
        $group->post('/logout', LogoutAuthAction::class)->add(AuthMiddleware::class);
    });

    $app->group('/users', function (Group $group) {
       $group->get('/getAllUsers', GetAllUsersAction::class);
       $group->post('/getUserById', GetUserByIdAction::class);
       $group->post('/updateUser', UpdateUserAction::class);
       $group->post('/createUser', CreateUserAction::class);
    })->add(AuthMiddleware::class)
        ->add(PermissionsMiddleware::class);

    $app->group('/players', function(Group $group) {
        $group->get('/getAllPlayers', GetAllPlayersAction::class);
        $group->post('/getPlayerById', GetPlayerByIdAction::class);
        $group->post('/updatePlayer', UpdatePlayer::class);
    })->add(AuthMiddleware::class)
        ->add(PermissionsMiddleware::class);

    $app->group('/vehicles', function (Group $group) {
        $group->get('/getAllVehicles', GetAllVehiclesAction::class);
    })->add(AuthMiddleware::class)
        ->add(PermissionsMiddleware::class);

    $app->group('/permissions', function(Group $group) {
        $group->post('/createNewRank', CreateNewRankAction::class);
        $group->post('/updateRank', UpdateRankAction::class);
        $group->post('/updateRankPermissions', UpdateRankPermissionsAction::class);
        //$group->post('/getAllRankPermissions', GetAllRankPermissionsAction::class);
        $group->post('/getAllPermissionsWithRank', GetAllPermissionsWithRank::class);
        $group->post('/getUsersRank', GetUserRankAction::class);
        $group->post('/userHasPermission', UserHasPermission::class);

        $group->get('/getAllPermissions', GetAllPermissionsAction::class);
        $group->get('/getAllRanks', GetAllRanksAction::class);
        $group->get('/getAllPermissionGroups', GetAllPermissionGroups::class);
    })->add(AuthMiddleware::class)
        ->add(PermissionsMiddleware::class);

    /**
     * Catch-all route to serve a 404 Not Found page if none of the routes match
     * NOTE: make sure this route is defined last
     */
    $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
        throw new HttpNotFoundException($request);
    });
};
