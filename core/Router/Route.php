<?php

namespace Core\Router;


class Route
{
    private $path;
    private $callable;
    private $matches;
    private $params = [];

    /**
     * Route constructor.
     * @param string $path
     * @param string $callable
     */
    public function __construct(string $path, string $callable)
    {
        $this->path = trim((string)$path, '/');
        $this->callable = $callable;
    }

    /**
     * @param string $params
     * @param string $regex
     * @return $this
     */
    public function with(string $params, string $regex)
    {
        $this->params[$params] = str_ireplace('(', '(?:', $regex);
        return $this;
    }

    /**
     * @param string $url
     * @return bool
     */
    public function match(string $url)
    {
        $url = trim($url, '/');
        $path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->path);
        $regex = "#$path$#i";
        if (!preg_match($regex, $url, $matches)) {
            return false;
        }
        array_shift($matches);
        $this->matches = $matches;

        return true;
    }

    /**
     * @param array $params
     * @return mixed|string
     */
    public function getUrl(array $params)
    {
        $path = $this->path;
        foreach ($params as $key => $value) {
            $path = str_replace(":key", $value, $path);
        }
        return $path;
    }

    /**
     * @param array $match
     * @return string
     */
    private function paramMatch(array $match)
    {
        if (isset($this->params[1])) {
            return '(' . $this->params[$match[1]] . ')';
        }
        return '([^/]+)';
    }

    /**
     * @param string $controllerType
     * @return mixed
     */
    public function call(string $controllerType)
    {
        if (is_string($this->callable)) {
            $params = explode('#', $this->callable);
            $controller = "App\\Controllers\\". $controllerType . '\\' . ucfirst($params[0]) . 'Controller';
            $controller = new $controller();
            return call_user_func_array([$controller, $params[1]], $this->matches);
        }
        return call_user_func_array($this->callable, $this->matches);
    }
}
