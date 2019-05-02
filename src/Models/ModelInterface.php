<?php

namespace App\Models;

interface ModelInterface
{
    public function list(string $value = null, string $key = null, int $order = 0);

    public function create(array $data);

    public function read(string $value, string $key = null);

    public function update(string $value, array $data, string $key = null);

    public function delete(string $value, string $key = null);
}
