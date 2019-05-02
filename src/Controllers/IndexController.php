<?php

namespace App\Controllers;

class IndexController extends Controller
{
    public function index()
    {
        echo $this->twig->render('index.html.twig');
    }
}
