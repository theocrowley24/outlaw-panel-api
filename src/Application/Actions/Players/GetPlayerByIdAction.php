<?php
/**
 * Copyright (c) 2020, Theo Crowley. All rights reserved.
 */

namespace App\Application\Actions\Players;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

class GetPlayerByIdAction extends PlayersAction
{
    protected function action(): Response
    {
        $parsedBody = $this->request->getParsedBody();
        $id = $parsedBody['id'];

        $data = $this->playersRepository->getPlayerById($id);

        return $this->respondWithData($data);
    }
}