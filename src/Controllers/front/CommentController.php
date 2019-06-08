<?php

namespace App\Controllers\front;

use Core\Model\ModelFactory;

class CommentController extends FrontController
{
    public function addComment($id)
    {
        if (!empty($_POST['comment'])) {
            $data = [
                'content' => $_POST['comment'],
                'id_article' => $id,
                'id_user' => $_SESSION['user']['id'],
                'date_add' => date('Y-m-d H:i:s')
            ];

            if (ModelFactory::get('Comment')->create($data)) {
                return true;
            } else{
                $this->errors[] = 'Erreur lors de l\'enregistrement';
            }
        }
    }
}
