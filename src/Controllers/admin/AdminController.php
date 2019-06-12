<?php

namespace App\Controllers\admin;

use App\Controllers\Controller;
use Core\Model\ModelFactory;
use Twig\Loader\FilesystemLoader;

class AdminController extends Controller
{
    public function __construct()
    {
        $loader = new FilesystemLoader('./../src/Views/admin');
        return parent::__construct($loader);
    }

    public function index()
    {
        if (isset($_SESSION['admin'])) {
        $users = ModelFactory::get('User')->list(null, null, 1);
        $articles = ModelFactory::get('Article')->getAllArticles();
        $comments = ModelFactory::get('Comment')->list(null, null, 1);
            echo $this->twig->render('admin/index.html.twig',
                [
                    'users' => count($users),
                    'articles' => $articles,
                    'comments' => $comments
                ]);
        } else {
            header('Location: /admin/login');
        }
    }
}
