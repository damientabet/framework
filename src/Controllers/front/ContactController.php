<?php

namespace App\Controllers\front;

class ContactController extends FrontController
{
    public function index()
    {
        echo $this->twig->render('contact.html.twig');
    }
}
