<?php

namespace App\Controllers;

use \Twig\Environment;

class Controller
{
    protected $twig;

    public function __construct($loader)
    {
        $className = substr(get_class($this), 12, -10);

        $this->twig = new Environment($loader, array(
            'cache' => false,
            'debug' => true
        ));
        $this->twig->addExtension(new \Twig_Extensions_Extension_Text());
        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
        $this->twig->addGlobal('session', $_SESSION);
    }
}
