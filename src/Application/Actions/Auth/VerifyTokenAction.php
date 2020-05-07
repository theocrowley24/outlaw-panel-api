<?php
declare(strict_types=1);

namespace App\Application\Actions\Auth;

use Slim\Psr7\Response as Psr7Response;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

class VerifyTokenAction extends AuthAction
{
    protected function action(): Response
    {
        $authToken = $_COOKIE['authToken'];

        if (!isset($_SESSION['token'])) {
            $response = new Psr7Response();
            $response->withStatus(401);
            $response->getBody()->write(json_encode(array("message" => "Failed to verify. Please login.")));
            return $response;
        }

        return $this->respondWithData(array("verified" => $authToken === $_SESSION['token']));
    }
}