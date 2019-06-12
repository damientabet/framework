<?php

namespace App\Controllers\Admin;

use Core\Model\ModelFactory;

class AdminUserController extends AdminController
{
    public function userPanel()
    {
        if (isset($_POST['deleteUser'])) {
            $this->deleteUser($_POST['id_user']);
            header('Location: /admin/users');
        }
        $users = ModelFactory::get('User')->list(null, null, 1);
        echo $this->twig->render('users/usersList.html.twig', ['users' => $users]);
    }

    public function viewUser($id)
    {
        $user = ModelFactory::get('User')->read($id, 'id_user');
        echo $this->twig->render('users/user.html.twig', ['user' => $user]);
    }

    public function deleteUser($id)
    {
        if (isset($_POST['deleteUser'])) {
            $user = ModelFactory::get('User')->read($id, 'id_user');
            unlink('../public/img/user/'.$user['image_name']);
            ModelFactory::get('Article')->delete($_SESSION['user']['id'], 'id_user');
            ModelFactory::get('Comment')->delete($_SESSION['user']['id'], 'id_user');
            if (ModelFactory::get('User')->delete($_SESSION['user']['id'], 'id_user')) {
                $this->logout();
                header('Location: /admin/users');
            }
        }
    }
}
