<?php

namespace App\Controllers;

use Core\Router\Router;

class FrontController extends Controller
{
    private $routes = array(
        "GET" => array(
            'article/:id-:slug' => array("controller" => "Article", "action" => "articleIndex"),
            'article/add' => array("controller" => "Article", "action" => "add"),
            'article/edit/:id' => array("controller" => "Article", "action" => "updateArticle"),
            'article/delete/:id' => array("controller" => "Article", "action" => "deleteArticle"),
            'authentification' => array("controller" => "User", "action" => "authentification"),
            'user/:id' => array("controller" => "User", "action" => "userIndex"),
            'user/article' => array("controller" => "Article", "action" => "articlesByUser"),
            'user/edit/:id' => array("controller" => "User", "action" => "updateUser"),
            'user/delete/:id' => array("controller" => "User", "action" => "deleteUser"),
            'logout' => array("controller" => "User", "action" => "logout"),
        ),
        "POST" => array(
            'article/delete/:id' => array("controller" => "Article", "action" => "deleteArticle"),
            'article/edit/:id' => array("controller" => "Article", "action" => "updateArticle"),
            'article/add' => array("controller" => "Article", "action" => "add"),
            'user/delete/:id' => array("controller" => "User", "action" => "deleteUser"),
            'user/edit/:id' => array("controller" => "User", "action" => "updateUser"),
            'authentification' => array("controller" => "User", "action" => "authentification"),
        )
    );

    public function run()
    {
        $router = new Router(isset($_GET['url']) ? $_GET['url'] : '/');
        $url = explode('/', $_GET['url']);

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

        $route = isset($this->routes[$_SERVER['REQUEST_METHOD']][$url]) ? $this->routes[$_SERVER['REQUEST_METHOD']][$url]: null;

        if ($route != null) {
            $router->dispatch($url, $route['controller'] . '#' . $route['action'], $_SERVER['REQUEST_METHOD']);
        } else {
            $router->dispatch('', 'Index#index', 'GET');
        }

        $router->run();
    }
}
