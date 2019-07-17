<?php

namespace App\Controllers\Admin;

use Core\Model\ModelFactory;

class AdminCommentController extends AdminController
{
    /**
     * @param int $id
     */
    public function approvedComment(int $id)
    {
        if (isset($this->post['approvedComment'])) {
            $data = ['approved' => 1];
            ModelFactory::get('Comment')->update((int)$id, (array)$data, 'id_comment');
            $this->redirect($this->server['HTTP_REFERER']);
        }
    }
}
