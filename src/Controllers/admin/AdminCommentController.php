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
        if (isset($_POST['approvedComment'])) {
            $data = [
                'approved' => 1,
            ];
            ModelFactory::get('Comment')->update((int)$id, (array)$data, 'id_comment');
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
    }
}
