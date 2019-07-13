<?php

session_start();

use Core\Router\Router;

require_once '../vendor/autoload.php';
require_once '../config/config.php';

$url = filter_input(INPUT_GET, 'url');
if (!isset($url)) {
    $url = '/';
}
$router = new Router($url);
$router->urlProcess($url);