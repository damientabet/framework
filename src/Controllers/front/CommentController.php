<?php

namespace App\Controllers\front;

use Core\Model\ModelFactory;

class CommentController extends FrontController
{
    /**
     * @param int $id
     * @return bool
     */
    public function addComment(int $id)
    {
        if (!empty($_POST['comment'])) {
            $data = [
                'content' => (string)$_POST['comment'],
                'id_article' => (int)$id,
                'id_user' => (int)$_SESSION['user']['id'],
                'date_add' => date('Y-m-d H:i:s')
            ];

            if (ModelFactory::get('Comment')->create((array)$data)) {
                return true;
            } else{
                $this->errors[] = 'Erreur lors de l\'enregistrement';
            }
        }
    }
}
