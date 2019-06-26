<?php

namespace App\Controllers\Admin;

use Core\Model\ModelFactory;

class AdminArticleController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION['admin'])) {
            header('Location: /admin/login');
        }
    }

    public function articlePanel()
    {
        if (isset($_POST['deleteArticle'])) {
            $this->deleteArticle($_POST['id_article']);
            header('Location: /admin/articles');
        }
        $articles = ModelFactory::get('Article')->getAllArticles();
        echo $this->twig->render('articles/articlesList.html.twig', ['articles' => $articles]);
    }

    public function viewArticle($id)
    {
        if (isset($_POST['approvedArticle'])) {
            $data = [
                'approved' => 1,
            ];
            ModelFactory::get('Article')->update($id, $data, 'id_article');
        }

        if (isset($_POST['deleteArticle'])) {
            $this->deleteArticle($_POST['id_article']);
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
        $comments = ModelFactory::get('Comment')->getCommentsByArticle($id);

        echo $this->twig->render('articles/article.html.twig',
            [
                'article' => $article,
                'comments' => $comments
            ]
        );
    }

    public function deleteArticle($id)
    {
        if (isset($_POST['deleteArticle'])) {
            ModelFactory::get('Comment')->delete($id, 'id_article');
            ModelFactory::get('Article')->delete($id, 'id_article');
            header('Location: /admin/articles');
        }
    }
}
