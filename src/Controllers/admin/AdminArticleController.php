<?php

namespace App\Controllers\Admin;

use Core\Model\ModelFactory;

class AdminArticleController extends AdminController
{
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
}
