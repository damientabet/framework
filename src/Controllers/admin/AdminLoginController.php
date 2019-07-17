<?php

namespace App\Controllers\admin;

use Core\Model\ModelFactory;

class AdminLoginController extends AdminController
{
    /**
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        return $this->twig->display('login.html.twig');
    }

    public function login()
    {
        if (isset($this->post['connectionAdmin'])) {
            $email = $this->post['connectionAdminEmail'];
            $admin = ModelFactory::get('Admin')->read($email, 'email');
            if (empty($this->post['connectionAdminEmail']) || empty($this->post['connectionAdminPasswd'])) {
                $this->redirect('/admin/login');
            }
            if ($admin) {
                if (password_verify($this->post['connectionAdminPasswd'], $admin['password'])) {
                    $_SESSION['admin'] = [
                        'id' => (int)$admin['id_admin'],
                        'lastname' => (string)$admin['lastname'],
                        'firstname' => (string)$admin['firstname'],
                        'email' => (string)$email
                    ];
                    $this->redirect('/admin');
                }
            }
            $this->errors[] = 'No matching user';
        }
    }

    public function logout()
    {
        session_destroy();
        $this->redirect('/admin/login');
    }
}
