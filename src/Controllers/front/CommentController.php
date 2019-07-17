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
        if (!empty($this->post['comment'])) {
            $data = [
                'content' => (string)$this->post['comment'],
                'id_article' => (int)$id,
                'id_user' => (int)$this->session['user']['id'],
                'date_add' => date('Y-m-d H:i:s')
            ];

            ModelFactory::get('Comment')->create((array)$data);
            $this->redirect($this->server['HTTP_REFERER']);
        }
    }
}
