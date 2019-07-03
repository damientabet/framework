<?php

namespace Core\Model;

use Core\Database\PDODatabase;
use Core\Database\PDOFactory;

class ModelFactory
{
    static private $models = [];

    /**
     * @param $table
     * @return mixed
     */
    static public function get($table)
    {
        if (array_key_exists($table, self::$models))
        {
            return self::$models[$table];
        }

        $class = 'App\Models\\' . ucfirst($table);

        $pdo = PDOFactory::getConnection();

        $database = new PDODatabase($pdo);

        $model = new $class($database);

        self::$models[$table] = $model;

        return $model;
    }
}
