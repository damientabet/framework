<?php

namespace App\Controllers\admin;

use Core\Model\ModelFactory;

class AdminCommentController extends AdminController
{
    /**
     * @param int $idy
     */
    public function approvedComment(int $idy)
    {
        if (isset($this->post['approvedComment'])) {
            $data = ['approved' => 1];
            ModelFactory::get('Comment')->update((int)$idy, (array)$data, 'id_comment');
            $this->redirect($this->server['HTTP_REFERER']);
        }
    }
}
