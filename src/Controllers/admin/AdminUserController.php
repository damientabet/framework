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
        if (isset($_POST['editUser'])) {
            $this->editUser($_POST['id_user']);
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
    public function editUser($id)
    {
        if (isset($_POST['editUser'])) {
            $data = [
                'firstname' => $_POST['firstname'],
                'lastname' => $_POST['lastname'],
                'email' => $_POST['email'],
                'date_upd' => date('Y-m-d H:i:s')
            ];

            if (!empty($_POST['password'])) {
                $data += [
                    'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                ];
            }
            
            ModelFactory::get('User')->update($id, $data, 'id_user');
        }
    }
}
