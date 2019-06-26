<?php

namespace App\Controllers\Admin;

use Core\Model\ModelFactory;

class AdminCommentController extends AdminController
{
    public function approvedComment($id)
    {
        if (isset($_POST['approvedComment'])) {
            $data = [
                'approved' => 1,
            ];
            ModelFactory::get('Comment')->update($id, $data, 'id_comment');
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
    }
}
