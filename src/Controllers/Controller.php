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
        $this->twig = new Environment($loader, array(
            'cache' => false,
            'debug' => true
        ));
        $this->twig->addExtension(new \Twig_Extensions_Extension_Text());
        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
        $this->twig->addGlobal('session', $_SESSION);
    }
}
