<?php
declare(strict_types=1);

namespace App\Domain;

use FaaPz\PDO\Database;
use FaaPz\PDO\Clause\Conditional;

class PlayersRepository extends Repository {
    public function updatePlayer(int $id, array $data) {
        $statement = $this->database
            ->update($data)
            ->table('`takistan-players`')
            ->where(new Conditional("id", "=", $id));

        $statement->execute();
    }

    public function getAllPlayers(): array {
        $statement = $this->database
        ->select(array('*'))
        ->from('`takistan-players`');

        $result = $statement->execute()->fetchAll();

        return $result;
    }

    public function getPlayerById(int $id): array {
        $statement = $this->database
        ->select(array('*'))
        ->from('`takistan-players`')
        ->where(new Conditional('id', '=', $id));

        $result = $statement->execute()->fetch();

        return $result;
    }
}