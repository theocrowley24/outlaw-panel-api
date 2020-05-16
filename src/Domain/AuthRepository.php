<?php
declare(strict_types=1);


namespace App\Domain;

use App\Domain\Repository;
use FaaPz\PDO\Clause\Conditional;

class AuthRepository extends Repository {
    public function getMyInfo(int $userId): array {
        $statement = $this->database
            ->select(array("username"))
            ->from("users")
            ->where(new Conditional("id", "=", $userId));

        return $statement->execute()->fetch();
    }

    public function login(string $username, string $password): bool {
        $statement = $this->database
        ->select(array("*"))
        ->from('users')
        ->where(new Conditional("username", "=", $username));

        $result = $statement->execute()->fetch();

        if ($statement->execute()->rowCount() === 0) {
            return false;
        }

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

        return $result['id'] !== null ? $result['id'] : -1;
    }

    public function verifyToken(string $authToken): bool {
        return $_SESSION['accessToken'] === $authToken;
    }
}