<?php

namespace App\Controllers\front;

use Core\Model\ModelFactory;

class ArticleController extends FrontController
{
    public $errors;

    public function articleView($id)
    {
        if (isset($_POST['addComment'])) {
            $comment = new CommentController();
            $comment->addComment($id);
            header('Location: /article/'.$id);
        }

        $article = ModelFactory::get('Article')->getArticleById($id, 'id_article');
        $comments = ModelFactory::get('Comment')->getCommentsByArticle($id);
        echo $this->twig->render('front/article/index.html.twig',
            [
                'article' => $article,
                'comments' => $comments
            ]);
    }

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

                    if (ModelFactory::get('Article')->create($data)) {
                        header('Location: /user/article');
                    } else{
                        $this->errors[] = 'Erreur lors de l\'enregistrement';
                    }
                } else {
                    $this->errors[] = 'Veuillez remplir tous les champs';
                }
            }

            echo $this->twig->render('front/article/add.html.twig', ['errors' => $this->errors]);
        } else {
            header('Location: /');
        }
    }

    public function deleteArticle($id)
    {
        if (isset($_SESSION['user'])) {
            if (isset($_POST['deleteArticle'])) {
                ModelFactory::get('Article')->delete($id);
                header('Location: /user/article');
            }
            echo $this->twig->render('front/article/delete.html.twig', ['article_id' => $id]);
        } else {
            header('Location: /');
        }
    }

    public function articlesByUser()
    {
        if (isset($_SESSION['user'])) {
            $articles = ModelFactory::get('Article')->list($_SESSION['user']['id'], 'id_user');
            echo $this->twig->render('front/user/articles.html.twig', ['articles' => $articles]);
        } else {
            header('Location: /');
        }
    }

    public function updateArticle($id)
    {
        if (isset($_SESSION['user'])) {
            if (isset($_POST['updateArticle'])) {
                $data = [
                    'title' => $_POST['titleArticle'],
                    'description' => $_POST['descArticle'],
                    'content' => $_POST['contentArticle'],
                ];
                ModelFactory::get('article')->update($id, $data, 'id_article');
            }
            $article = ModelFactory::get('article')->read($id, 'id_article');

            echo $this->twig->render('front/article/edit.html.twig',
                [
                    "article" => $article
                ]
            );
        } else {
            header('Location: /');
        }
    }
}
