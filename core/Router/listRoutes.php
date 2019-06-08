<?php

namespace core\Router;

class listRoutes
{
    protected $routes = array(
        "GET" => array(
            'admin/article/:id' =>
                array(
                    "controller" => "Admin",
                    "action" => "viewArticle",
                    "test" => 'admin'
                ),
            'admin/articles' =>
                array(
                    "controller" => "Admin",
                    "action" => "articlePanel",
                    "test" => 'admin'
                ),
            'admin/user/:id' =>
                array(
                    "controller" => "Admin",
                    "action" => "viewUser",
                    "test" => 'admin'
                ),
            'admin/users' =>
                array(
                    "controller" => "Admin",
                    "action" => "userPanel",
                    "test" => 'admin'
                ),
            'admin/login' =>
                array(
                    "controller" => "Admin",
                    "action" => "loginAdmin",
                    "test" => 'admin'
                ),
            'admin/logout' =>
                array(
                    "controller" => "Admin",
                    "action" => "logoutAdmin",
                    "test" => 'admin'
                ),
            'admin' =>
                array(
                    "controller" => "Admin",
                    "action" => "index",
                    "test" => 'admin'
                ),
            'article/:id' =>
                array(
                    "controller" => "Article",
                    "action" => "articleView",
                    'test' => 'front'
                ),
            'article/add' =>
                array(
                    "controller" => "Article",
                    "action" => "add",
                    'test' => 'front'
                ),
            'article/edit/:id' =>
                array(
                    "controller" => "Article",
                    "action" => "updateArticle",
                    'test' => 'front'
                ),
            'article/delete/:id' =>
                array(
                    "controller" => "Article",
                    "action" => "deleteArticle",
                    'test' => 'front'
                ),
            'authentification' =>
                array(
                    "controller" => "User",
                    "action" => "authentification",
                    'test' => 'front'
                ),
            'user/:id' =>
                array(
                    "controller" => "User",
                    "action" => "userIndex",
                    'test' => 'front'
                ),
            'user/article' =>
                array(
                    "controller" => "Article",
                    "action" => "articlesByUser",
                    'test' => 'front'
                ),
            'user/edit/:id' =>
                array(
                    "controller" => "User",
                    "action" => "updateUser",
                    'test' => 'front'
                ),
            'user/delete/:id' =>
                array(
                    "controller" => "User",
                    "action" => "deleteUser",
                    'test' => 'front'
                ),
            'logout' =>
                array(
                    "controller" => "User",
                    "action" => "logout",
                    'test' => 'front'
                ),
        ),
        "POST" => array(
            'admin/article/:id' =>
                array(
                    "controller" => "Admin",
                    "action" => "viewArticle",
                    'test' => 'admin'
                ),
            'admin/authentification' =>
                array(
                    "controller" => "Admin",
                    "action" => "connectionAdmin",
                    'test' => 'admin'
                ),
            'article/delete/:id' =>
                array(
                    "controller" => "Article",
                    "action" => "deleteArticle",
                    'test' => 'front'
                ),
            'article/edit/:id' =>
                array(
                    "controller" => "Article",
                    "action" => "updateArticle",
                    'test' => 'front'
                ),
            'article/add' =>
                array(
                    "controller" => "Article",
                    "action" => "add",
                    'test' => 'front'
                ),
            'article/:id' =>
                array(
                    "controller" => "Comment",
                    "action" => "addComment",
                    'test' => 'front'
                ),
            'user/delete/:id' =>
                array(
                    "controller" => "User",
                    "action" => "deleteUser",
                    'test' => 'front'
                ),
            'user/edit/:id' =>
                array(
                    "controller" => "User",
                    "action" => "updateUser",
                    'test' => 'front'
                ),
            'authentification' =>
                array(
                    "controller" => "User",
                    "action" => "authentification",
                    'test' => 'front'
                ),
        )
    );

    public function getRoutes()
    {
        return $this->routes;
    }
}
