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
        if (isset($this->post['connection']) && preg_match('#^\w+@\w+.(fr|com)#', $this->post['connection_email'])) {
            $email = (string)$this->post['connection_email'];
            $user = ModelFactory::get('User')->read((string)$email, 'email');
            if (empty($this->post['connection_email']) || empty($this->post['connection_password'])) {
                $this->errors[] = 'Please fill fields';
            }
            if ($user) {
                if (password_verify($this->post['connection_password'], $user['password'])) {
                    $_SESSION['user'] = [
                        'id' => $user['id_user'],
                        'lastname' => $user['lastname'],
                        'firstname' => $user['firstname'],
                        'email' => $email
                    ];
                    $this->redirect($this->server['HTTP_REFERER']);
                }
            }
            $this->errors[] = 'No matching user';
        }
        $this->redirect($this->server['HTTP_REFERER']);
    }

    public function logout()
    {
        session_destroy();
        $this->redirect($this->server['HTTP_REFERER']);
    }
}
