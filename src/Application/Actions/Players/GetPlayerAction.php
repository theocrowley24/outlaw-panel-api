<?php

namespace App\Application\Actions\Players;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

class GetPlayerAction extends PlayersAction {
    protected function action(): Response {
        return $this->respondWithData();
    }
}