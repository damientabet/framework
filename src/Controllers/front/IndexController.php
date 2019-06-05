<?php

namespace App\Controllers\front;

use Core\Model\ModelFactory;

class IndexController extends FrontController
{
    public function index()
    {
        $articles = ModelFactory::get('Article')->getAllArticles();
        echo $this->twig->render('front/index.html.twig', ['articles' => $articles]);
    }
}
