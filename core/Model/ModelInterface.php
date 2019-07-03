<?php

namespace Core\Model;

interface ModelInterface
{
    /**
     * @param string|null $value
     * @param string|null $key
     * @param int $order
     * @return mixed
     */
    public function list(string $value = null, string $key = null, int $order = 0);

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * @param string $value
     * @param string|null $key
     * @return mixed
     */
    public function read(string $value, string $key = null);

    /**
     * @param string $value
     * @param array $data
     * @param string|null $key
     * @return mixed
     */
    public function update(string $value, array $data, string $key = null);

    /**
     * @param string $value
     * @param string|null $key
     * @return mixed
     */
    public function delete(string $value, string $key = null);
}
