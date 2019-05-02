<?php

namespace App\Models;

use App\Models\Db\DatabaseInterface;

abstract class Model implements ModelInterface
{
    protected $database;
    protected $table;

    public function __construct(DatabaseInterface $database)
    {
        $this->database = $database;

        $modelName = explode('\\', get_class($this));

        $this->table = ucfirst(str_replace('Model', '', array_pop($modelName)));
    }

    public function list(string $value = null, string $key = null, int $order = 0)
    {
        if (isset($key))
        {
            if ($order == 1)
            {
                $query = 'SELECT * FROM ' . $this->table . ' WHERE ' . $key . ' = ?';
            }
            else {
                $query = 'SELECT * FROM ' . $this->table . ' WHERE ' . $key . ' = ? ORDER BY ' . $key . ' DESC';
            }
            return $this->database->results($query, [$value]);
        }
        else {
            if ($order == 1)
            {
                $query = 'SELECT * FROM ' . $this->table;
            }
            else {
                $query = 'SELECT * FROM ' . $this->table . ' ORDER BY id DESC';
            }
            return $this->database->results($query);
        }
    }

    public function create(array $data)
    {
        $keys = implode(', ', array_keys($data));
        $values = implode('", "', $data);

        $query = 'INSERT INTO ' . $this->table . ' (' . $keys . ') VALUES ("' . $values . '")';

        $this->database->action($query);
    }

    public function read(string $value, string $key = null)
    {
        if (isset($key))
        {
            $query = 'SELECT * FROM ' . $this->table . ' WHERE ' . $key . ' = ?';
        }
        else {
            $query = 'SELECT * FROM ' . $this->table . ' WHERE id = ?';
        }
        return $this->database->result($query, [$value]);
    }

    public function update(string $value, array $data, string $key = null)
    {
        $set = null;

        foreach ($data as $dataKey => $dataValue)
        {
            $set .= $dataKey . ' = "' . $dataValue . '", ';
        }

        $set = substr_replace($set, '', -2);

        if (isset($key))
        {
            $query = 'UPDATE ' . $this->table . ' SET ' . $set . ' WHERE ' . $key . ' = ?';
        }
        else {
            $query = 'UPDATE ' . $this->table . ' SET ' . $set . ' WHERE id = ?';
        }
        $this->database->action($query, [$value]);
    }

    public function delete(string $value, string $key = null)
    {
        if (isset($key))
        {
            $query = 'DELETE FROM ' . $this->table . ' WHERE ' . $key . ' = ?';
        }
        else {
            $query = 'DELETE FROM ' . $this->table . ' WHERE id = ?';
        }
        $this->database->action($query, [$value]);
    }
}
