<?php

use App\Controllers\FrontController;

require_once "../vendor/autoload.php";
require_once "../config/config.php";

session_start();

$frontController = new FrontController();
$frontController->run();
