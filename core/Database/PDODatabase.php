<?php

namespace Core\Database;

class PDODatabase implements DatabaseInterface
{
    private $pdo;

    /**
     * PDODatabase constructor.
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param string $query
     * @param array $params
     * @return mixed
     */
    public function get(string $query, array $params = [])
    {
        $PDOStatement = $this->pdo->prepare($query);

        $PDOStatement->execute($params);

        return $PDOStatement->fetch();
    }

    /**
     * @param string $query
     * @param array $params
     * @return array
     */
    public function getAll(string $query, array $params = [])
    {
        $PDOStatement = $this->pdo->prepare($query);

        $PDOStatement->execute($params);

        return $PDOStatement->fetchAll();
    }

    /**
     * @param string $query
     * @param array $params
     * @return bool
     */
    public function action(string $query, array $params = [])
    {
        $PDOStatement = $this->pdo->prepare($query);

        return $PDOStatement->execute($params);
    }
}
