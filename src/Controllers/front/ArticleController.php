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
        echo $this->twig->render('article/index.html.twig',
            [
                'articles' => $articles
            ]);
    }

    /**
     * @param int $id
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function articleView(int $id)
    {
        if (isset($_POST['addComment'])) {
            $comment = new CommentController();
            $comment->addComment((int)$id);
            header('Location: /article/'.(int)$id);
        }

        $article = ModelFactory::get('Article')->getArticleById((int)$id, 'id_article');
        $comments = ModelFactory::get('Comment')->getCommentsByArticle((int)$id);
        echo $this->twig->render('article/article.html.twig',
            [
                'article' => $article,
                'comments' => $comments
            ]);
    }

    /**
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add()
    {
        if (isset($_SESSION['user'])) {
            if (isset($_POST['addArticle'])) {
                if (!empty($_POST['titleArticle']) || !empty($_POST['contentArticle']) || !empty($_POST['descArticle'])) {
                    $data = [
                        'title' => $_POST['titleArticle'],
                        'description' => $_POST['descArticle'],
                        'content' => $_POST['contentArticle'],
                        'id_user' => $_SESSION['user']['id'],
                        'date_add' => date('Y-m-d H:i:s')
                    ];

                    if (ModelFactory::get('Article')->create((array)$data)) {
                        header('Location: /user/article');
                    } else{
                        $this->errors[] = 'Erreur lors de l\'enregistrement';
                    }
                } else {
                    $this->errors[] = 'Veuillez remplir tous les champs';
                }
            }

            echo $this->twig->render('article/add.html.twig', ['errors' => $this->errors]);
        } else {
            header('Location: /');
        }
    }

    /**
     * @param int $id
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function deleteArticle(int $id)
    {
        if (isset($_SESSION['user'])) {
            if (isset($_POST['deleteArticle'])) {
                ModelFactory::get('Article')->delete((int)$id);
                header('Location: /user/article');
            }
            echo $this->twig->render('article/delete.html.twig', ['article_id' => (int)$id]);
        } else {
            header('Location: /');
        }
    }

    /**
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function articlesByUser()
    {
        if (isset($_SESSION['user'])) {
            $articles = ModelFactory::get('Article')->list($_SESSION['user']['id'], 'id_user');
            echo $this->twig->render('user/articles.html.twig', ['articles' => (array)$articles]);
        } else {
            header('Location: /');
        }
    }

    /**
     * @param int $id
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function updateArticle(int $id)
    {
        if (isset($_SESSION['user'])) {
            if (isset($_POST['updateArticle'])) {
                $data = [
                    'title' => $_POST['titleArticle'],
                    'description' => $_POST['descArticle'],
                    'content' => $_POST['contentArticle'],
                ];
                ModelFactory::get('article')->update((int)$id, (array)$data, 'id_article');
            }
            $article = ModelFactory::get('article')->read((int)$id, 'id_article');

            echo $this->twig->render('article/edit.html.twig',
                [
                    "article" => $article
                ]
            );
        } else {
            header('Location: /');
        }
    }
}
