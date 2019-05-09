<?php

namespace App\Controllers;

use Core\Model\ModelFactory;

class IndexController extends Controller
{
    public function index()
    {
        $articles = ModelFactory::get('Article')->articles();
        echo $this->twig->render('index.html.twig', ['articles' => $articles]);
    }
}
