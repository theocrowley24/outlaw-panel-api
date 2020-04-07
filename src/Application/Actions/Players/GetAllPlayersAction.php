<?php

namespace App\Application\Actions\Players;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

class GetAllPlayersAction extends PlayersAction {
    protected function action(): Response {
        $data = $this->playersRepository->getAllPlayers();

        return $this->respondWithData($data);
    }
}