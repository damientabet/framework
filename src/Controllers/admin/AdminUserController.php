<?php

namespace App\Controllers\Admin;

use Core\Model\ModelFactory;

class AdminUserController extends AdminController
{
    public function userPanel()
    {
        $users = ModelFactory::get('User')->list(null, null, 1);
        echo $this->twig->render('admin/user.html.twig', ['users' => $users]);
    }

    public function viewUser($id)
    {
        $user = ModelFactory::get('User')->read($id, 'id_user');
        echo $this->twig->render('admin/viewUser.html.twig', ['user' => $user]);
    }
}
