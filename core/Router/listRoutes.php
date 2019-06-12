<?php

namespace core\Router;

class listRoutes
{
    protected $routes = array(
        "GET" => array(
            'admin/article/:id' =>
                array(
                    "controller" => "AdminArticle",
                    "action" => "viewArticle",
                    "controllerType" => 'admin'
                ),
            'admin/articles' =>
                array(
                    "controller" => "AdminArticle",
                    "action" => "articlePanel",
                    "controllerType" => 'admin'
                ),
            'admin/user/:id' =>
                array(
                    "controller" => "AdminUser",
                    "action" => "viewUser",
                    "controllerType" => 'admin'
                ),
            'admin/users' =>
                array(
                    "controller" => "AdminUser",
                    "action" => "userPanel",
                    "controllerType" => 'admin'
                ),
            'admin/login' =>
                array(
                    "controller" => "Admin",
                    "action" => "loginAdmin",
                    "controllerType" => 'admin'
                ),
            'admin/logout' =>
                array(
                    "controller" => "Admin",
                    "action" => "logoutAdmin",
                    "controllerType" => 'admin'
                ),
            'admin' =>
                array(
                    "controller" => "Admin",
                    "action" => "index",
                    "controllerType" => 'admin'
                ),
            'article/:id' =>
                array(
                    "controller" => "Article",
                    "action" => "articleView",
                    'controllerType' => 'front'
                ),
            'article/add' =>
                array(
                    "controller" => "Article",
                    "action" => "add",
                    'controllerType' => 'front'
                ),
            'article/edit/:id' =>
                array(
                    "controller" => "Article",
                    "action" => "updateArticle",
                    'controllerType' => 'front'
                ),
            'article/delete/:id' =>
                array(
                    "controller" => "Article",
                    "action" => "deleteArticle",
                    'controllerType' => 'front'
                ),
            'authentification' =>
                array(
                    "controller" => "Login",
                    "action" => "authentification",
                    'controllerType' => 'front'
                ),
            'user/:id' =>
                array(
                    "controller" => "User",
                    "action" => "userIndex",
                    'controllerType' => 'front'
                ),
            'user/article' =>
                array(
                    "controller" => "Article",
                    "action" => "articlesByUser",
                    'controllerType' => 'front'
                ),
            'user/edit/:id' =>
                array(
                    "controller" => "User",
                    "action" => "updateUser",
                    'controllerType' => 'front'
                ),
            'user/delete/:id' =>
                array(
                    "controller" => "User",
                    "action" => "deleteUser",
                    'controllerType' => 'front'
                ),
            'logout' =>
                array(
                    "controller" => "Login",
                    "action" => "logout",
                    'controllerType' => 'front'
                ),
            '' =>
                array(
                    "controller" => "Front",
                    "action" => "index",
                    'controllerType' => 'front'
                ),
        ),
        "POST" => array(
            'admin/article/:id' =>
                array(
                    "controller" => "AdminArticle",
                    "action" => "viewArticle",
                    'controllerType' => 'admin'
                ),
            'admin/authentification' =>
                array(
                    "controller" => "Admin",
                    "action" => "connectionAdmin",
                    'controllerType' => 'admin'
                ),
            'article/delete/:id' =>
                array(
                    "controller" => "Article",
                    "action" => "deleteArticle",
                    'controllerType' => 'front'
                ),
            'article/edit/:id' =>
                array(
                    "controller" => "Article",
                    "action" => "updateArticle",
                    'controllerType' => 'front'
                ),
            'article/add' =>
                array(
                    "controller" => "Article",
                    "action" => "add",
                    'controllerType' => 'front'
                ),
            'article/:id' =>
                array(
                    "controller" => "Comment",
                    "action" => "addComment",
                    'controllerType' => 'front'
                ),
            'user/delete/:id' =>
                array(
                    "controller" => "User",
                    "action" => "deleteUser",
                    'controllerType' => 'front'
                ),
            'user/edit/:id' =>
                array(
                    "controller" => "User",
                    "action" => "updateUser",
                    'controllerType' => 'front'
                ),
            'authentification' =>
                array(
                    "controller" => "Login",
                    "action" => "login",
                    'controllerType' => 'front'
                ),
        )
    );

    public function getRoutes()
    {
        return $this->routes;
    }
}
