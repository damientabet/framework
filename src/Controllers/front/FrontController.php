<?php

namespace App\Controllers\front;

use App\Controllers\Controller;
use Core\Model\ModelFactory;
use Twig\Loader\FilesystemLoader;

class FrontController extends Controller
{
    /**
     * FrontController constructor.
     */
    public function __construct()
    {
        $loader = new FilesystemLoader('./../src/Views/front');
        parent::__construct($loader);
    }

    /**
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $articles = ModelFactory::get('Article')->getAllArticles();
        echo $this->twig->render('index.html.twig', ['articles' => $articles]);
    }
}
