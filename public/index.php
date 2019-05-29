<?php

session_start();

use Core\Router\Router;

require_once "../vendor/autoload.php";
require_once "../config/config.php";

$router = new Router(isset($_GET['url']) ? $_GET['url'] : '/');
$router->urlProcess($_GET['url']);