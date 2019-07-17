<?php

namespace App\Controllers;

use \Twig\Environment;

class Controller
{
    protected $twig;

    public $post;
    public $server;
    public $session;
    public $files;

    /**
     * Controller constructor.
     * @param $loader
     */
    public function __construct($loader)
    {
        $this->post = filter_input_array(INPUT_POST);
        $this->server = filter_input_array(INPUT_SERVER, FILTER_SANITIZE_URL);
        $this->session = filter_var_array($_SESSION);
        $this->files = filter_var_array($_FILES);

        substr(get_class($this), 12, -10);

        $this->twig = new Environment($loader, array(
            'cache' => false,
            'debug' => true
        ));
        $this->twig->addExtension(new \Twig_Extensions_Extension_Text());
        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
        $this->twig->addGlobal('session', $this->session);
    }

    public function redirect($url)
    {
        header('Location: ' . $url);
        exit;
    }
}
