<?php

namespace App\database;

use PDO;
use PDOException;
use PDOStatement;

class DB {
    private PDO $pdo;
    private string $error;
    private PDOStatement $stmt;

    public function __construct() {
        $dsn = sprintf("mysql:host=%s;dbname=%s;charset=%s", $_ENV['DB_HOST'], $_ENV['DB_DATABASE'], $_ENV['DB_CHARSET']);

        //  PDO options
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        // Create a new PDO instance
        try {
            $this->pdo = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    public function query(string $sql): static
    {
        $this->stmt = $this->pdo->prepare($sql);

        return $this;
    }

    public function bind($param, $value, $type = null): static
    {
        if (is_null($type)) {
            $type = match (true) {
                is_int($value) => PDO::PARAM_INT,
                is_bool($value) => PDO::PARAM_BOOL,
                is_null($value) => PDO::PARAM_NULL,
                default => PDO::PARAM_STR,
            };
        }

        $this->stmt->bindValue($param, $value, $type);

        return $this;
    }

    public function execute(): bool
    {
        return $this->stmt->execute();
    }

    public function resultSet(): false|array
    {
        $this->execute();

        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function single() {
        $this->execute();

        return $this->stmt->fetch();
    }
}