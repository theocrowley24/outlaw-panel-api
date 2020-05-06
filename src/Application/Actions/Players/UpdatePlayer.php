<?php
declare(strict_types=1);

namespace App\Application\Actions\Players;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

class UpdatePlayer extends PlayersAction
{
    private $columnNames = array(
        "lastName" => "last_name",
        "cash" => "cash",
        "bank" => "bank",
        "profession" => "profession",
        "gear" => "gear",
        "natoRank" => "NATO_rank",
        "alive" => "alive",
        "adminlevel" => "adminlevel"
    );

    protected function action(): Response
    {
        $parsedBody = $this->request->getParsedBody();
        $playerId = $parsedBody['id'];
        $data = $parsedBody['data'];

        $convertedColumnNames = array();
        foreach ($data as $key => $value) {
            $convertedColumnNames[$this->columnNames[$key]] = $value;
        }

        $this->playersRepository->updatePlayer($playerId, $convertedColumnNames);

        return $this->respondWithData("Updated player");
    }
}