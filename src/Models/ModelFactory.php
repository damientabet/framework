<?php

namespace App\Models;

use App\Models\Db\PDODatabase;
use App\Models\Db\PDOFactory;

class ModelFactory
{
    static private $models = [];

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
