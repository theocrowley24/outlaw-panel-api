<?php
declare(strict_types=1);

namespace App\Domain;

use FaaPz\PDO\Database;
use FaaPz\PDO\Clause\Conditional;

class Repository {
    protected $database;

    public function __construct()
    {
        $dsn = 'mysql:host=localhost;dbname=panel;charset=utf8';
        $usr = 'root';
        $pwd = '12345';

        $this->database = new Database($dsn, $usr, $pwd);
    }
    
    public function inheritanceTest(): array {
        $statement = $this->database->select()->from('users')->where(new Conditional("id", "=", 1));
        $data = $statement->execute()->fetch();

        return $data;
    }
}