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
        if (isset($_POST['connectionAdmin'])) {
            $email = $_POST['connectionAdminEmail'];
            $admin = ModelFactory::get('Admin')->read($email, 'email');
            if (empty($_POST['connectionAdminEmail']) || empty($_POST['connectionAdminPasswd'])) {
                header('Location: /admin/login');
            }
            if ($admin) {
                if (password_verify($_POST['connectionAdminPasswd'], $admin['password'])) {
                    $_SESSION['admin'] = [
                        'id' => (int)$admin['id_admin'],
                        'lastname' => (string)$admin['lastname'],
                        'firstname' => (string)$admin['firstname'],
                        'email' => (string)$email
                    ];
                    header('Location: /admin');
                }
            } else {
                $this->errors[] = 'No matching user';
            }
        }
    }

    public function logout()
    {
        session_destroy();
        header('Location: /admin/login');
    }
}
