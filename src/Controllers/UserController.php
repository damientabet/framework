<?php

namespace App\Controllers;

use App\Models\ModelFactory;
use App\Models\User;

class UserController extends Controller
{
    public $errors = [];

    public function userIndex($id)
    {
        $user = ModelFactory::get('User')->read($id, 'id');
        echo $this->twig->render('user/account.html.twig',
            [
                "user" => $user
            ]
        );
    }

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

    public function updateUser($id)
    {
        if (isset($_POST['updateUser'])) {
            $data = [
                'firstname' => $_POST['firstname'],
                'lastname' => $_POST['lastname'],
                'email' => $_POST['email']
            ];

            ModelFactory::get('User')->update($id, $data);
        }
        $user = ModelFactory::get('User')->read($id, 'id');

        echo $this->twig->render('user/edit.html.twig',
            [
                "user" => $user
            ]
        );
    }

    public function deleteUser($id)
    {
        if (isset($_POST['deleteUser'])) {
            if (ModelFactory::get('User')->delete($id)) {
                header('Location: /');
            }
        }
        echo $this->twig->render('user/delete.html.twig', ['user_id' => $id]);
    }
}
