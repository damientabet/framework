<?php

namespace App\Controllers\front;

use Core\Model\ModelFactory;

class UserController extends FrontController
{
    public $errors = [];

    /**
     * @param int $id
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function userIndex(int $id)
    {
        $user = ModelFactory::get('User')->read((int)$id, 'id_user');
        if (isset($_SESSION['user'])) {
            return $this->twig->display('user/account.html.twig',
                [
                    "user" => $user
                ]
            );
        } else {
            header('Location: /');
        }
    }

    /**
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function authentification()
    {
        $this->createUser();

        return $this->twig->display('authentification.html.twig',
            [
                'errors' => $this->errors
            ]);
    }

    /**
     * @return array
     */
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
                    'lastname' => (string)$_POST['lastname'],
                    'firstname' => (string)$_POST['firstname'],
                    'email' => (string)$_POST['email'],
                    'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                    'image_name' => 'default.png',
                    'date_add' => date('Y-m-d H:i:s'),
                    'date_upd' => date('Y-m-d H:i:s')
                ];
                ModelFactory::get('User')->create((array)$data);

                $user = ModelFactory::get('User')->read($data['email'], 'email');
                // TODO : A checker !
                // $session = $_SESSION['user']['id'];
                $_SESSION['user'] = [
                    'id' => (string)$user['id_user'],
                    'lastname' => (string)$user['lastname'],
                    'firstname' => (string)$user['firstname'],
                    'email' => (string)$user['email']
                ];
                header('Location: /user/' . $_SESSION['user']['id']);
            } else {
                return $this->errors;
            }
        }
    }

    /**
     * @param int $id
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError(string)
     */
    public function updateUser(int $id)
    {
        if (isset($_SESSION['user'])) {
            if (isset($_POST['deleteImg'])) {
                $user = ModelFactory::get('User')->read((int)$id, 'id_user');
                ModelFactory::get('User')->update($_SESSION['user']['id'], ['image_name' => null], 'id_user');
                unlink('../public/img/user/'.$user['image_name']);
            }

            if (isset($_POST['updateUser'])) {
                // Ajout de l'image
                if (isset($_FILES['userImg'])) {
                    $extension = new \SplFileInfo($_FILES['userImg']['name']);
                    $extension = $extension->getExtension();
                    $acceptExtension = ['jpg', 'png'];
                    if (in_array($extension, $acceptExtension)) {
                        $imgName = (int)$id . '.' . $extension;
                        $imgDirname = IMG_USER_DIR.$imgName;
                        if (move_uploaded_file($_FILES['userImg']['tmp_name'], $imgDirname)) {
                            ModelFactory::get('User')->update($_SESSION['user']['id'], ['image_name' => $imgName], 'id_user');
                            header('Location: /user/edit/'.(int)$id);
                        } else {
                            return 'Erreur lors du téléchargement de l\'image';
                        }
                    } else {
                        return 'L\'extension de l\'image n\'est pas correct : '.$acceptExtension;
                    }
                }
                $data = [
                    'firstname' => (string)$_POST['firstname'],
                    'lastname' => (string)$_POST['lastname'],
                    'email' => (string)$_POST['email'],
                    'date_upd' => date('Y-m-d H:i:s')
                ];

                ModelFactory::get('User')->update($_SESSION['user']['id'], $data, 'id_user');
            }

            $user = ModelFactory::get('User')->read($_SESSION['user']['id'], 'id_user');

            return $this->twig->display('user/edit.html.twig',
                [
                    "user" => $user
                ]
            );
        } else {
            header('Location: /');
        }
    }

    /**
     * @param int $id
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function deleteUser(int $id)
    {
        if (isset($_SESSION['user'])) {
            if (isset($_POST['deleteUser'])) {
                $user = ModelFactory::get('User')->read((int)$id, 'id_user');
                unlink('../public/img/user/'.$user['image_name']);
                ModelFactory::get('Article')->delete((int)$_SESSION['user']['id'], 'id_user');
                if (ModelFactory::get('User')->delete((int)$_SESSION['user']['id'])) {
                    $this->logout();
                    header('Location: /');
                }
            }
            return $this->twig->display('user/delete.html.twig', ['user_id' => (int)$_SESSION['user']['id']]);
        } else {
            header('Location: /');
        }
    }
}
