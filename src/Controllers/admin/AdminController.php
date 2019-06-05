<?php

namespace App\Controllers\admin;

use App\Controllers\Controller;
use Core\Model\ModelFactory;

class AdminController extends Controller
{
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

    public function userPanel()
    {
        $users = ModelFactory::get('User')->list(null, null, 1);
        echo $this->twig->render('admin/user.html.twig', ['users' => $users]);
    }

    public function articlePanel()
    {
        $articles = ModelFactory::get('Article')->getAllArticles();
        echo $this->twig->render('admin/articles.html.twig', ['articles' => $articles]);
    }

    public function viewArticle($id)
    {
        if (isset($_SESSION['admin'])) {
            if (isset($_POST['approvedArticle'])) {
                $data = [
                    'approved' => 1,
                ];
                ModelFactory::get('Article')->update($id, $data, 'id_article');
            }

            if (isset($_POST['deleteArticle'])) {
                ModelFactory::get('Article')->deleteArticle($id);
                header('Location: /admin/articles');
            }

            if (isset($_POST['editAdminArticle'])) {
                $data = [
                    'title' => $_POST['titleArticle'],
                    'description' => $_POST['descArticle'],
                    'content' => $_POST['contentArticle'],
                ];
                ModelFactory::get('Article')->update($id, $data, 'id_article');
            }
            $article = ModelFactory::get('Article')->getArticleById($id);

            echo $this->twig->render('admin/viewArticle.html.twig', ['article' => $article]);
        } else {
            header('Location: /admin/login');
        }
    }

    public function viewUser($id)
    {
        $user = ModelFactory::get('User')->read($id, 'id_user');
        echo $this->twig->render('admin/viewUser.html.twig', ['user' => $user]);
    }
}
