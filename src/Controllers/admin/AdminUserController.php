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
        if (!isset($this->session['admin'])) {
            $this->redirect('/admin/login');
        }
    }

    /**
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function userPanel()
    {
        if (isset($this->post['deleteUser'])) {
            $this->deleteUser($this->post['id_user']);
            $this->redirect('/admin/users');
        }
        if (isset($this->post['editUser'])) {
            $this->editUser($this->post['id_user']);
            $this->redirect('/admin/users');
        }
        $users = ModelFactory::get('User')->list(null, null, 1);
        return $this->twig->display('users/usersList.html.twig', ['users' => $users]);
    }

    /**
     * @param int $idy
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function viewUser(int $idy)
    {
        $user = ModelFactory::get('User')->read((int)$idy, 'id_user');
        return $this->twig->display('users/user.html.twig', ['user' => $user]);
    }

    /**
     * @param int $idy
     */
    public function deleteUser(int $idy)
    {
        if (isset($this->post['deleteUser'])) {
            $user = ModelFactory::get('User')->read((int)$idy, 'id_user');
            unlink('../public/img/user/'.$user['image_name']);
            ModelFactory::get('Article')->delete($user['id_user'], 'id_user');
            ModelFactory::get('Comment')->delete($user['id_user'], 'id_user');
            if (ModelFactory::get('User')->delete($user['id_user'], 'id_user')) {
                $this->redirect('/admin/users');
            }
        }
    }

    /**
     * @param int $idy
     */
    public function editUser(int $idy)
    {
        if (isset($this->post['editUser'])) {
            $data = [
                'firstname' => (string)$this->post['firstname'],
                'lastname' => (string)$this->post['lastname'],
                'email' => (string)$this->post['email'],
                'date_upd' => date('Y-m-d H:i:s')
            ];

            if (!empty($this->post['password'])) {
                $data += [
                    'password' => password_hash($this->post['password'], PASSWORD_DEFAULT),
                ];
            }
            
            ModelFactory::get('User')->update((int)$idy, $data, 'id_user');
        }
    }
}
