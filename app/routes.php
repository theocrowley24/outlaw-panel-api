<?php
declare(strict_types=1);

use App\Application\Actions\Auth\LoginAuthAction;
use App\Application\Actions\Players\GetAllPlayersAction;
use App\Application\Actions\Players\GetPlayerByIdAction;

use App\Application\Middleware\AuthMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->group('/auth', function (Group $group) {
        $group->post('/login', LoginAuthAction::class);
    });//->add(AuthMiddleware::class);

    $app->group('/players', function(Group $group) {
        $group->get('/getAllPlayers', GetAllPlayersAction::class);
        $group->post('/getPlayerById', GetPlayerByIdAction::class);
    });

    /**
     * Catch-all route to serve a 404 Not Found page if none of the routes match
     * NOTE: make sure this route is defined last
     */
    $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
        throw new HttpNotFoundException($request);
    });
};
