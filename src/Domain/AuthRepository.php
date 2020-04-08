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

    public function logout(int $id): void {
        $statement = $this->database
        ->update(array("access_token" => ""))
        ->table("users")
        ->where(new Conditional("id", "=", $id));

        $statement->execute();
    }

    public function getToken(string $username): string {
        $statement = $this->database
        ->select(array("access_token"))
        ->from('users')
        ->where(new Conditional("username", "=", $username));

        $result = $statement->execute()->fetch();

        return $result['access_token'];
    }

    public function getTokenById(int $id): string {
        $statement = $this->database
        ->select(array("access_token"))
        ->from('users')
        ->where(new Conditional("id", "=", $id));

        $result = $statement->execute()->fetch();

        return $result['access_token'];
    }

    public function getUid(string $username): int {
        $statement = $this->database
        ->select(array("id"))
        ->from('users')
        ->where(new Conditional("username", "=", $username));

        $result = $statement->execute()->fetch();

        return $result['id'];
    }

    public function checkToken(int $uid, string $authToken): bool {
        $statement = $this->database
        ->select(array("access_token"))
        ->from('users')
        ->where(new Conditional("id", "=", $uid));

        $result = $statement->execute()->fetch();

        if (strcmp($result['access_token'], $authToken) != 0) {
            return false;
        }

        return true;
    }
}