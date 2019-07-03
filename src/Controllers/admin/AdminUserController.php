<?php

namespace App\Controllers\Admin;

use Core\Model\ModelFactory;

class AdminUserController extends AdminController
{
    /**
     * AdminUserController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION['admin'])) {
            header('Location: /admin/login');
        }
    }

    /**
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
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
        return $this->twig->display('users/usersList.html.twig', ['users' => $users]);
    }

    /**
     * @param int $id
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function viewUser(int $id)
    {
        $user = ModelFactory::get('User')->read((int)$id, 'id_user');
        return $this->twig->display('users/user.html.twig', ['user' => $user]);
    }

    /**
     * @param int $id
     */
    public function deleteUser(int $id)
    {
        if (isset($_POST['deleteUser'])) {
            $user = ModelFactory::get('User')->read((int)$id, 'id_user');
            unlink('../public/img/user/'.$user['image_name']);
            ModelFactory::get('Article')->delete($user['id_user'], 'id_user');
            ModelFactory::get('Comment')->delete($user['id_user'], 'id_user');
            if (ModelFactory::get('User')->delete($user['id_user'], 'id_user')) {
                header('Location: /admin/users');
            }
        }
    }

    /**
     * @param int $id
     */
    public function editUser(int $id)
    {
        if (isset($_POST['editUser'])) {
            $data = [
                'firstname' => (string)$_POST['firstname'],
                'lastname' => (string)$_POST['lastname'],
                'email' => (string)$_POST['email'],
                'date_upd' => date('Y-m-d H:i:s')
            ];

            if (!empty($_POST['password'])) {
                $data += [
                    'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                ];
            }
            
            ModelFactory::get('User')->update((int)$id, $data, 'id_user');
        }
    }
}
