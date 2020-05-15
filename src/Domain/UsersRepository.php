<?php


namespace App\Domain;


use FaaPz\PDO\Clause\Conditional;
use FaaPz\PDO\Clause\Join;

class UsersRepository extends Repository
{
    public function getAllUsers(): array {
        $result = $this->database->query("SELECT 
            users.id, users.username, ranks.`name` AS rank_name, ranks.id AS rank_id
            FROM users
            JOIN ranks ON users.rank_id = ranks.id")->fetchAll();

        return $result;
    }

}