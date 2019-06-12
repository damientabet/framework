<?php

namespace App\Controllers;

use App\Controllers\admin\AdminController;
use Core\Model\ModelFactory;

class AdminLoginController extends AdminController
{
    public function loginAdmin()
    {
        echo $this->twig->render('login.html.twig');
    }

    public function connectionAdmin()
    {
        if (isset($_POST['connectionAdmin'])) {
            $email = $_POST['connectionAdminEmail'];
            $admin = ModelFactory::get('Admin')->read($email, 'email');
            if (empty($_POST['connectionAdminEmail']) || empty($_POST['connectionAdminPasswd'])) {
                header('Location: /admin/login');
                // return $this->errors[] = 'Please fill fields';
            }
            if ($admin) {
                if (password_verify($_POST['connectionAdminPasswd'], $admin['password'])) {
                    $_SESSION['admin'] = [
                        'id' => $admin['id_admin'],
                        'lastname' => $admin['lastname'],
                        'firstname' => $admin['firstname'],
                        'email' => $email
                    ];
                    header('Location: /admin');
                }
            } else {
                $this->errors[] = 'No matching user';
            }
        }
        //else {
        //header('Location: /admin/login');
        //continue;
        // return false;
        //}
    }

    public function logoutAdmin()
    {
        session_destroy();
        header('Location: /admin/login');
    }
}
