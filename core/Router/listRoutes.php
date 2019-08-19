<?php

namespace core\Router;

class listRoutes
{
    protected $routes = array(
        "GET" => array(
            '404-not-found' =>
                array(
                    "controller" => "404NotFound",
                    "action" => "index",
                    "controllerType" => 'front'
                ),
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
                    "controller" => "AdminLogin",
                    "action" => "index",
                    "controllerType" => 'admin'
                ),
            'admin/logout' =>
                array(
                    "controller" => "AdminLogin",
                    "action" => "logout",
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
            'articles' =>
                array(
                    "controller" => "Article",
                    "action" => "index",
                    'controllerType' => 'front'
                ),
            'authentification' =>
                array(
                    "controller" => "User",
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
            'contact' =>
                array(
                    "controller" => "Contact",
                    "action" => "index",
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
            'admin/comment/:id' =>
                array(
                    "controller" => "AdminComment",
                    "action" => "approvedComment",
                    'controllerType' => 'admin'
                ),
            'admin/users' =>
                array(
                    "controller" => "AdminUser",
                    "action" => "userPanel",
                    'controllerType' => 'admin'
                ),
            'admin/article/:id' =>
                array(
                    "controller" => "AdminArticle",
                    "action" => "viewArticle",
                    'controllerType' => 'admin'
                ),
            'admin/articles' =>
                array(
                    "controller" => "AdminArticle",
                    "action" => "articlePanel",
                    'controllerType' => 'admin'
                ),
            'admin/authentification' =>
                array(
                    "controller" => "AdminLogin",
                    "action" => "login",
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
            'contact' =>
                array(
                    "controller" => "Contact",
                    "action" => "sendMail",
                    'controllerType' => 'front'
                ),
            'authentification' =>
                array(
                    "controller" => "User",
                    "action" => "authentification",
                    'controllerType' => 'front'
                ),
            'login' =>
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
