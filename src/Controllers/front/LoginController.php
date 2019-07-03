<?php

namespace App\Controllers\front;

use Core\Model\ModelFactory;

class LoginController extends FrontController
{
    public $errors;

    /**
     * @return bool|string
     */
    public function login()
    {
        if (isset($_POST['connection'])) {
            $email = (string)$_POST['connection_email'];
            $user = ModelFactory::get('User')->read((string)$email, 'email');
            if (empty($_POST['connection_email']) || empty($_POST['connection_password'])) {
                return $this->errors[] = 'Please fill fields';
            }
            if ($user) {
                if (password_verify($_POST['connection_password'], $user['password'])) {
                    $_SESSION['user'] = [
                        'id' => $user['id_user'],
                        'lastname' => $user['lastname'],
                        'firstname' => $user['firstname'],
                        'email' => $email
                    ];
                    header('Location: ' . $_SERVER["HTTP_REFERER"]);
                }
            } else {
                $this->errors[] = 'No matching user';
            }
        } else {
            return false;
        }
    }

    public function logout()
    {
        session_destroy();
        header('Location: /');
    }
}
