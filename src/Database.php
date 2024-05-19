<?php

class Database
{
    public function __construct(private string $dbHost, private string $dbName, private string $dbUser, private string $dbPassword)
    {

    }

    public function getConnection(): \PDO
    {
        $dsn = "mysql:host={$this->dbHost};dbname={$this->dbName};charset=utf8";
        return new PDO($dsn, $this->dbUser, $this->dbPassword, [
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_STRINGIFY_FETCHES => false
        ] );
    }
}