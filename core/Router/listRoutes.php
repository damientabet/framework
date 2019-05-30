<?php

namespace core\Router;

class listRoutes
{
    protected $routes = array(
        "GET" => array(
            'article/:id' =>
                array(
                    "controller" => "Article",
                    "action" => "articleView"
                ),
            'article/add' =>
                array(
                    "controller" => "Article",
                    "action" => "add"
                ),
            'article/edit/:id' =>
                array(
                    "controller" => "Article",
                    "action" => "updateArticle"
                ),
            'article/delete/:id' =>
                array(
                    "controller" => "Article",
                    "action" => "deleteArticle"
                ),
            'authentification' =>
                array(
                    "controller" => "User",
                    "action" => "authentification"
                ),
            'user/:id' =>
                array(
                    "controller" => "User",
                    "action" => "userIndex"
                ),
            'user/article' =>
                array(
                    "controller" => "Article",
                    "action" => "articlesByUser"
                ),
            'user/edit/:id' =>
                array(
                    "controller" => "User",
                    "action" => "updateUser"
                ),
            'user/delete/:id' =>
                array(
                    "controller" => "User",
                    "action" => "deleteUser"
                ),
            'logout' =>
                array(
                    "controller" => "User",
                    "action" => "logout"
                ),
        ),
        "POST" => array(
            'article/delete/:id' =>
                array(
                    "controller" => "Article",
                    "action" => "deleteArticle"
                ),
            'article/edit/:id' =>
                array(
                    "controller" => "Article",
                    "action" => "updateArticle"
                ),
            'article/add' =>
                array(
                    "controller" => "Article",
                    "action" => "add"
                ),
            'article/:id' =>
                array(
                    "controller" => "Comment",
                    "action" => "addComment"
                ),
            'user/delete/:id' =>
                array(
                    "controller" => "User",
                    "action" => "deleteUser"
                ),
            'user/edit/:id' =>
                array(
                    "controller" => "User",
                    "action" => "updateUser"
                ),
            'authentification' =>
                array(
                    "controller" => "User",
                    "action" => "authentification"
                ),
        )
    );

    public function getRoutes()
    {
        return $this->routes;
    }
}
