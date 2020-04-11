<?php
declare(strict_types=1);


namespace App\Domain;

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
        $_SESSION["accessToken"] = $token;

        return true;
    }

    public function logout(int $id): void {
        unset($_SESSION['accessToken']);
    }

    public function getToken(): string {
        return $_SESSION['accessToken'];
    }

    public function getTokenById(int $id): string {
        return $_SESSION['accessToken'];
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
        return $_SESSION['accessToken'] === $authToken;
    }

    public function verifyToken(string $authToken): bool {
        return $_SESSION['accessToken'] === $authToken;
    }
}