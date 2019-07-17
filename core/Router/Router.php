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
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * @param string $url
     * @throws RouterException
     */
    public function urlProcess(string $url)
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
        }

        $this->run($this->controllerType);
    }

    /**
     * @param string $path
     * @param string $callable
     * @param string $method
     * @return Route
     */
    public function dispatch(string $path, string $callable, string $method)
    {
        if ($method == 'GET') {
            return $this->get($path, $callable);
        } elseif ($method == 'POST') {
            return $this->post($path, $callable);
        }
    }

    /**
     * @param string $path
     * @param string $callable
     * @param string|null $name
     * @return Route
     */
    public function get(string $path, string $callable, string $name = null)
    {
        return $this->add($path, $callable, $name, 'GET');
    }

    /**
     * @param string $path
     * @param string $callable
     * @param string|null $name
     * @return Route
     */
    public function post(string $path, string $callable, string $name = null)
    {
        return $this->add($path, $callable, $name, 'POST');
    }

    /**
     * @param string $path
     * @param string $callable
     * @param $name
     * @param string $method
     * @return Route
     */
    private function add(string $path, string $callable, $name, string $method)
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
     * @param string $controllerType
     * @return mixed
     * @throws RouterException
     */
    public function run(string $controllerType)
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
     * @param string $name
     * @param array $params
     * @return mixed
     * @throws RouterException
     */
    public function url(string $name, array $params = [])
    {
        if (!isset($this->namedRoutes[$name]))
        {
            throw new RouterException('No routes matches this name');
        }
        return $this->namedRoutes[$name]->getUrl($params);
    }
}
