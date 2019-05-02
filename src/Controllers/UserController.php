<?php

namespace App\Controllers;

use App\Models\ModelFactory;
use App\Models\User;

class UserController extends Controller
{
    public $errors = [];

    public function authentification()
    {
        $this->createUser();

        echo $this->twig->render('authentification.html.twig',
            [
                'errors' => $this->errors
            ]);
    }

    public function createUser()
    {
        if (isset($_POST['addUser'])) {

            if (empty($_POST['lastname'])) {
                $this->errors[] = 'No lastname';
            }
            if (empty($_POST['firstname'])) {
                $this->errors[] = 'No firstname';
            }
            if (empty($_POST['email'])) {
                $this->errors[] = 'No email';
            }
            if (empty($_POST['password'])) {
                $this->errors[] = 'No password';
            }

            if (!$this->errors) {
                $data = [
                    'lastname' => $_POST['lastname'],
                    'firstname' => $_POST['firstname'],
                    'email' => $_POST['email'],
                    'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                    'date_add' => date('Y-m-d H:i:s')
                ];
                ModelFactory::get('User')->create($data);

                $user = ModelFactory::get('User')->read($data['email'], 'email');
                // TODO : A checker !
                // $session = $_SESSION['user']['id'];
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'lastname' => $user['lastname'],
                    'firstname' => $user['firstname'],
                    'email' => $user['email']
                ];
                header('Location: /');
            } else {
                return $this->errors;
            }
        }
    }
}
