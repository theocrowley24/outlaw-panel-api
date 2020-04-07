<?php
declare(strict_types=1);

namespace App\Domain;

use FaaPz\PDO\Database;
use FaaPz\PDO\Clause\Conditional;

class PlayersRepository extends Repository {
    public function getAllPlayers(): array {
        $statement = $this->database
        ->select(array('*'))
        ->from('players');

        $result = $statement->execute()->fetch();

        return $result;
    }

    public function getPlayerById(int $id): array {
        $statement = $this->database
        ->select(array('*'))
        ->from('players')
        ->where(new Conditional('id', '=', $id));

        $result = $statement->execute()->fetch();

        return $result;
    }
}