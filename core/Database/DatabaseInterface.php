<?php

namespace Core\Database;

interface DatabaseInterface
{
    public function get(string $query, array $params = []);

    public function getAll(string $query, array $params = []);

    public function action(string $query, array $params = []);
}
