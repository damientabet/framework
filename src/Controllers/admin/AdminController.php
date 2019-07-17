<?php

namespace App\Controllers\admin;

use App\Controllers\Controller;
use Core\Model\ModelFactory;
use Twig\Loader\FilesystemLoader;

class AdminController extends Controller
{
    /**
     * AdminController constructor.
     */
    public function __construct()
    {
        $loader = new FilesystemLoader('./../src/Views/admin');
        return parent::__construct($loader);
    }

    /**
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        if (isset($this->session['admin'])) {
        $users = ModelFactory::get('User')->list(null, null, 1);
        $articles = ModelFactory::get('Article')->getAllArticles();
        $comments = ModelFactory::get('Comment')->getAllComments();
            return $this->twig->display('index.html.twig', [
                    'users' => count($users),
                    'articles' => $articles,
                    'comments' => $comments]);
        }

        return $this->redirect('/admin/login');
    }
}
