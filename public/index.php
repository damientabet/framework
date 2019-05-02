<?php

use App\Router\Router;
use Tracy\Debugger;

require_once "../vendor/autoload.php";

Debugger::enable();

$router = new Router(isset($_GET['url']) ? $_GET['url'] : 'index');

$router->get('/', 'Index#index');

$router->run();