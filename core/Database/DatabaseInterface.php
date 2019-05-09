<?php

namespace Core\Database;

interface DatabaseInterface
{
    public function result(string $query, array $params = []);

    public function results(string $query, array $params = []);

    public function action(string $query, array $params = []);
}
