<?php

namespace App\Models\Db;

class PDODatabase implements DatabaseInterface
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function result(string $query, array $params = [])
    {
        $PDOStatement = $this->pdo->prepare($query);

        $PDOStatement->execute($params);

        return $PDOStatement->fetch();
    }

    public function results(string $query, array $params = [])
    {
        $PDOStatement = $this->pdo->prepare($query);

        $PDOStatement->execute($params);

        return $PDOStatement->fetchAll();
    }

    public function action(string $query, array $params = [])
    {
        $PDOStatement = $this->pdo->prepare($query);

        return $PDOStatement->execute($params);
    }
}
