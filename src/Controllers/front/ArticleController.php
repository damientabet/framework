<?php

namespace App\Controllers\front;

use Core\Model\ModelFactory;

class ArticleController extends FrontController
{
    public $errors;

    /**
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $articles = ModelFactory::get('Article')->getAllArticles();
        return $this->twig->display('article/index.html.twig', [
                'articles' => $articles]);
    }

    /**
     * @param int $idy
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function articleView(int $idy)
    {
        if (isset($this->post['addComment'])) {
            $comment = new CommentController();
            $comment->addComment((int)$idy);
            $this->redirect('/article/'.(int)$idy);
        }

        $article = ModelFactory::get('Article')->getArticleById((int)$idy, 'id_article');
        $comments = ModelFactory::get('Comment')->getCommentsByArticle((int)$idy);
        return $this->twig->display('article/article.html.twig', [
                'article' => $article,
                'comments' => $comments]);
    }

    /**
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add()
    {
        if (isset($this->session['user'])) {
            if (isset($this->post['addArticle'])) {
                if (!empty($this->post['titleArticle']) || !empty($this->post['descArticle']) || !empty($this->post['contentArticle'])) {
                    $data = [
                        'title' => $this->post['titleArticle'],
                        'description' => $this->post['descArticle'],
                        'content' => $this->post['contentArticle'],
                        'id_user' => $this->session['user']['id'],
                        'date_add' => date('Y-m-d H:i:s')
                    ];

                    if (ModelFactory::get('Article')->create((array)$data)) {
                        $this->redirect('/user/article');
                    } else{
                        $this->errors[] = 'Erreur lors de l\'enregistrement';
                    }
                } else {
                    $this->errors[] = 'Veuillez remplir tous les champs';
                }
            }

            return $this->twig->display('article/add.html.twig', ['errors' => $this->errors]);
        }
        $this->redirect('/');
    }

    /**
     * @param int $idy
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function deleteArticle(int $idy)
    {
        if (isset($this->session['user'])) {
            if (isset($this->post['deleteArticle'])) {
                ModelFactory::get('Comment')->delete((int)$idy, 'id_article');
                ModelFactory::get('Article')->delete((int)$idy, 'id_article');
               $this->redirect('/user/article');
            }
            return $this->twig->display('article/delete.html.twig', ['article_id' => (int)$idy]);
        }
       $this->redirect('/');
    }

    /**
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function articlesByUser()
    {
        if (isset($this->session['user'])) {
            $articles = ModelFactory::get('Article')->list($this->session['user']['id'], 'id_user');
            return $this->twig->display('user/articles.html.twig', ['articles' => (array)$articles]);
        }
       $this->redirect('/');
    }

    /**
     * @param int $idy
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function updateArticle(int $idy)
    {
        if (isset($this->session['user'])) {
            if (isset($this->post['updateArticle'])) {
                $data = [
                    'title' => $this->post['titleArticle'],
                    'description' => $this->post['descArticle'],
                    'content' => $this->post['contentArticle'],
                ];
                ModelFactory::get('article')->update((int)$idy, (array)$data, 'id_article');
            }
            $article = ModelFactory::get('article')->read((int)$idy, 'id_article');

            return $this->twig->display('article/edit.html.twig', [
                    "article" => $article]);
        }
        $this->redirect('/');
    }
}
