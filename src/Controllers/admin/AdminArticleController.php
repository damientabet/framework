<?php

namespace App\Controllers\Admin;

use Core\Model\ModelFactory;

class AdminArticleController extends AdminController
{
    /**
     * AdminArticleController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION['admin'])) {
            header('Location: /admin/login');
        }
    }

    /**
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function articlePanel()
    {
        if (isset($_POST['deleteArticle'])) {
            $this->deleteArticle($_POST['id_article']);
            header('Location: /admin/articles');
        }
        $articles = ModelFactory::get('Article')->getAllArticles();
        return $this->twig->display('articles/articlesList.html.twig', ['articles' => $articles]);
    }

    /**
     * @param int $id
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function viewArticle(int $id)
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
            ModelFactory::get('Article')->update((int)$id, (array)$data, 'id_article');
        }
        $article = ModelFactory::get('Article')->getArticleById((int)$id);
        $comments = ModelFactory::get('Comment')->getCommentsByArticle((int)$id);

        return $this->twig->display('articles/article.html.twig',
            [
                'article' => $article,
                'comments' => $comments
            ]
        );
    }

    /**
     * @param int $id
     */
    public function deleteArticle(int $id)
    {
        if (isset($_POST['deleteArticle'])) {
            ModelFactory::get('Comment')->delete((int)$id, 'id_article');
            ModelFactory::get('Article')->delete((int)$id, 'id_article');
            header('Location: /admin/articles');
        }
    }
}
