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

        if (password_verify($password, $result['password_hashed'])) {
            return true;
        }

        return false;
    }
}