<?php

namespace App\Controllers;

use \Twig\Loader\FilesystemLoader;
use \Twig\Environment;

class Controller
{
    protected $twig;

    public function __construct()
    {
        $className = substr(get_class($this), 12, -10);

        $loader = new FilesystemLoader('./../src/Views/');
        $this->twig = new Environment($loader, array('cache' => false));
        $this->twig->addGlobal('session', $_SESSION);
    }
}
