<?php
/**
 * Copyright (c) 2020, Theo Crowley. All rights reserved.
 */

declare(strict_types=1);

namespace App\Domain;

use FaaPz\PDO\Database;
use FaaPz\PDO\Clause\Conditional;

class Repository
{
    protected $database;

    public function __construct()
    {
        $dsn = 'mysql:host=localhost;dbname=takistan-life;charset=utf8';
        $usr = 'root';
        $pwd = '12345';

        $this->database = new Database($dsn, $usr, $pwd);
    }
}