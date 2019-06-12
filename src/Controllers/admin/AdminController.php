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

    public function loginAdmin()
    {
        echo $this->twig->render('admin/login.html.twig');
    }

    public function connectionAdmin()
    {
        if (isset($_POST['connectionAdmin'])) {
            $email = $_POST['connectionAdminEmail'];
            $admin = ModelFactory::get('Admin')->read($email, 'email');
            if (empty($_POST['connectionAdminEmail']) || empty($_POST['connectionAdminPasswd'])) {
                header('Location: /admin/login');
                // return $this->errors[] = 'Please fill fields';
            }
            if ($admin) {
                if (password_verify($_POST['connectionAdminPasswd'], $admin['password'])) {
                    $_SESSION['admin'] = [
                        'id' => $admin['id_admin'],
                        'lastname' => $admin['lastname'],
                        'firstname' => $admin['firstname'],
                        'email' => $email
                    ];
                    header('Location: /admin');
                }
            } else {
                $this->errors[] = 'No matching user';
            }
        }
        //else {
            //header('Location: /admin/login');
            //continue;
            // return false;
        //}
    }

    public function logoutAdmin()
    {
        session_destroy();
        header('Location: /admin/login');
    }
}
