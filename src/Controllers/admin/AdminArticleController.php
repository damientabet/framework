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
        if (!isset($this->session['admin'])) {
            $this->redirect('/admin/login');
        }
    }

    /**
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function articlePanel()
    {
        if (isset($this->post['deleteArticle'])) {
            $this->deleteArticle($this->post['id_article']);
            $this->redirect('/admin/articles');
        }
        $articles = ModelFactory::get('Article')->getAllArticles();
        return $this->twig->display('articles/articlesList.html.twig', ['articles' => $articles]);
    }

    /**
     * @param int $idy
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function viewArticle(int $idy)
    {
        if (isset($this->post['approvedArticle'])) {
            $data = [
                'approved' => 1,
            ];
            ModelFactory::get('Article')->update($idy, $data, 'id_article');
        }

        if (isset($this->post['deleteArticle'])) {
            $this->deleteArticle($this->post['id_article']);
            $this->redirect('/admin/articles');
        }

        if (isset($this->post['editAdminArticle'])) {
            $data = [
                'title' => $this->post['titleArticle'],
                'description' => $this->post['descArticle'],
                'content' => $this->post['contentArticle'],
            ];
            ModelFactory::get('Article')->update((int)$idy, (array)$data, 'id_article');
        }
        $article = ModelFactory::get('Article')->getArticleById((int)$idy);
        $comments = ModelFactory::get('Comment')->getCommentsByArticle((int)$idy);

        return $this->twig->display('articles/article.html.twig', [
                'article' => $article,
                'comments' => $comments]);
    }

    /**
     * @param int $idy
     */
    public function deleteArticle(int $idy)
    {
        if (isset($this->post['deleteArticle'])) {
            ModelFactory::get('Comment')->delete((int)$idy, 'id_article');
            ModelFactory::get('Article')->delete((int)$idy, 'id_article');
            $this->redirect('/admin/articles');
        }
    }
}
