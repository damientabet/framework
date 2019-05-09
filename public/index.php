<?php

use Core\Router\Router;
use Tracy\Debugger;

require_once "../vendor/autoload.php";

Debugger::enable();

session_start();

$router = new Router(isset($_GET['url']) ? $_GET['url'] : 'index');

$router->get('/user/delete/:id', 'User#deleteUser');
$router->get('/user/edit/:id', 'User#updateUser');
$router->get('/user/:id', 'User#userIndex');
$router->get('/authentification', 'User#authentification');
$router->get('/', 'Index#index');

$router->post('/user/delete/:id', 'User#deleteUser');
$router->post('/user/edit/:id', 'User#updateUser');

// Connexion et déconnexion de l'utilisateur
$router->post('/authentification', 'User#authentification');
$router->post('/logout', 'User#logout');

$router->run();