<?php
declare(strict_types=1);


namespace App\Domain\Auth;

use App\Domain\Repository;
use FaaPz\PDO\Clause\Conditional;

class AuthRepository extends Repository {
    public function login(string $username, string $password): bool {
        $statement = $this->database
        ->select(array("*"))
        ->from('users')
        ->where(new Conditional("username", "=", $username));

        $result = $statement->execute()->fetch();

        if (!password_verify($password, $result['password_hashed'])) {
            return false;
        }

        $token = bin2hex(random_bytes(16));
        $tokenStatement = $this->database
        ->update(array("access_token" => $token))
        ->table("users")
        ->where(new Conditional("id", "=", $result['id']));

        $tokenStatement->execute();

        return true;
    }

    public function getToken(string $username): string {
        $statement = $this->database
        ->select(array("access_token"))
        ->from('users')
        ->where(new Conditional("username", "=", $username));

        $result = $statement->execute()->fetch();

        return $result['access_token'];
    }
}