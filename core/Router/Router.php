<?php

namespace Core\Router;

/**
 * Class Router
 * @package Router
 */
class Router
{
    private $url;
    private $routes = [];
    private $namedRoutes = [];
    private $controllerType;

    /**
     * Router constructor.
     * @param $url
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    public function urlProcess($url)
    {
        $routeAction = new listRoutes();
        $routeAction = $routeAction->getRoutes();

        $url = explode('/', $url);

        switch (count($url)){
            case '2' :
                if (is_numeric($url[1])) {
                    $url = $url[0].'/:id';
                } elseif (is_string($url[1]) && strstr('-', $url[1])) {
                    $url = $url[0].'/:id-:slug';
                } else {
                    $url = implode('/', $url);
                }
                break;
            case '3' :
                $url = $url[0].'/'.$url[1].'/:id';
                break;
            default :
                $url = implode('/', $url);
                break;
        }

        $route = isset($routeAction[$_SERVER['REQUEST_METHOD']][$url]) ? $routeAction[$_SERVER['REQUEST_METHOD']][$url]: null;

        $this->controllerType = ($route != null) ? $route['controllerType'] : 'front';

        if ($route != null) {
            $this->dispatch($url, $route['controller'] . '#' . $route['action'], $_SERVER['REQUEST_METHOD']);
        } else {
            $this->dispatch('/', 'Error#notFound', 'GET');
        }

        $this->run($this->controllerType);
    }

    /**
     * @param $path
     * @param $callable
     * @param $method
     * @return Route
     */
    public function dispatch($path, $callable, $method)
    {
        if ($method == 'GET') {
            return $this->get($path, $callable);
        } elseif ($method == 'POST') {
            return $this->post($path, $callable);
        }
    }

    /**
     * @param $path
     * @param $callable
     * @param null $name
     * @return Route
     */
    public function get($path, $callable, $name = null)
    {
        return $this->add($path, $callable, $name, 'GET');
    }

    /**
     * @param $path
     * @param $callable
     * @param null $name
     * @return Route
     */
    public function post($path, $callable, $name = null)
    {
        return $this->add($path, $callable, $name, 'POST');
    }

    /**
     * @param $path
     * @param $callable
     * @param $name
     * @param $method
     * @return Route
     */
    private function add($path, $callable, $name, $method)
    {
        $route = new Route($path, $callable);
        $this->routes[$method][] = $route;
        if (is_string($callable) && $name === null){
            $name = $callable;
        }
        if ($name)
        {
            $this->namedRoutes[$name] = $route;
        }
        return $route;
    }

    /**
     * @return mixed
     * @throws RouterException
     */
    public function run($controllerType)
    {
        if (!isset($this->routes[$_SERVER['REQUEST_METHOD']])) {
            throw new RouterException('REQUEST_METHOD does not exist');
        }

        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if ($route->match($this->url)) {
                return $route->call($controllerType);
            }
        }
        throw new RouterException('No matching routes');
    }

    /**
     * @param $name
     * @param array $params
     * @return mixed
     * @throws RouterException
     */
    public function url($name, $params = [])
    {
        if (!isset($this->namedRoutes[$name]))
        {
            throw new RouterException('No routes matches this name');
        }
        return $this->namedRoutes[$name]->getUrl($params);
    }
}
