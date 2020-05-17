<?php
/**
 * Copyright (c) 2020, Theo Crowley. All rights reserved.
 */

namespace App\Domain;


use FaaPz\PDO\Clause\Conditional;
use FaaPz\PDO\Clause\Join;

class UsersRepository extends Repository
{
    public function createUser(array $data): bool {
        $username = $data["username"];
        $password = $data["password"];
        $rankId = $data["rankId"];

        $statement = $this->database
            ->insert(array("username" => $username, "password_hashed" => password_hash($password, PASSWORD_DEFAULT), "rank_id" => $rankId))
            ->into("users");

        return $statement->execute() >= 0;
    }


    public function updateUser(int $id, array $data): bool
    {
        if (isset($data["reset_password"]) && !empty($data["reset_password"])) {
            $password = password_hash($data["reset_password"], PASSWORD_DEFAULT);


            $statement = $this->database
                ->update(array("password_hashed" => $password))
                ->table("users")
                ->where(new Conditional("id", "=", $id));

            return $statement->execute() >= 0;
        }

        unset($data["reset_password"]);

        $data["inactive"] = $data["inactive"] === 'true' ? 1 : 0;

        $statement = $this->database
            ->update($data)
            ->table("users")
            ->where(new Conditional("id", "=", $id));

        return $statement->execute() >= 0;
    }

    public function getAllUsers(): array
    {
        $result = $this->database->query("SELECT 
            users.id, users.username, ranks.`name` AS rank_name, ranks.id AS rank_id
            FROM users
            JOIN ranks ON users.rank_id = ranks.id")->fetchAll();

        return $result;
    }

    public function getUserById(int $id): array
    {
        $result = $this->database->query("SELECT 
            users.id, users.username, ranks.`name` AS rank_name, ranks.id AS rank_id
            FROM users
            JOIN ranks ON users.rank_id = ranks.id
            WHERE users.id = $id")->fetch();

        return $result;
    }

}