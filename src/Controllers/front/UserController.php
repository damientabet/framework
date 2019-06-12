<?php

namespace App\Controllers\front;

use Core\Model\ModelFactory;

class UserController extends FrontController
{
    public $errors = [];

    public function userIndex($id)
    {
        $user = ModelFactory::get('User')->read($id, 'id_user');
        if (isset($_SESSION['user'])) {
            echo $this->twig->render('user/account.html.twig',
                [
                    "user" => $user
                ]
            );
        } else {
            header('Location: /');
        }
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
                    'image_name' => 'default.png',
                    'date_add' => date('Y-m-d H:i:s'),
                    'date_upd' => date('Y-m-d H:i:s')
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
                header('Location: /user/' . $_SESSION['user']['id']);
            } else {
                return $this->errors;
            }
        }
    }

    public function updateUser($id)
    {
        if (isset($_SESSION['user'])) {
            if (isset($_POST['deleteImg'])) {
                $user = ModelFactory::get('User')->read($id, 'id_user');
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
                        $imgName = $id . '.' . $extension;
                        $imgDirname = IMG_USER_DIR.$imgName;
                        if (move_uploaded_file($_FILES['userImg']['tmp_name'], $imgDirname)) {
                            ModelFactory::get('User')->update($_SESSION['user']['id'], ['image_name' => $imgName], 'id_user');
                            header('Location: /user/edit/'.$id);
                        } else {
                            echo 'Erreur lors du téléchargement de l\'image';
                        }
                    } else {
                        echo 'L\'extension de l\'image n\'est pas correct : '.$acceptExtension;
                    }
                }
                $data = [
                    'firstname' => $_POST['firstname'],
                    'lastname' => $_POST['lastname'],
                    'email' => $_POST['email'],
                    'date_upd' => date('Y-m-d H:i:s')
                ];

                ModelFactory::get('User')->update($_SESSION['user']['id'], $data, 'id_user');
            }

            $user = ModelFactory::get('User')->read($_SESSION['user']['id'], 'id_user');

            echo $this->twig->render('user/edit.html.twig',
                [
                    "user" => $user
                ]
            );
        } else {
            header('Location: /');
        }
    }

    public function deleteUser($id)
    {
        if (isset($_SESSION['user'])) {
            if (isset($_POST['deleteUser'])) {
                $user = ModelFactory::get('User')->read($id, 'id_user');
                unlink('../public/img/user/'.$user['image_name']);
                ModelFactory::get('Article')->delete($_SESSION['user']['id'], 'id_user');
                if (ModelFactory::get('User')->delete($_SESSION['user']['id'])) {
                    $this->logout();
                    header('Location: /');
                }
            }
            echo $this->twig->render('user/delete.html.twig', ['user_id' => $_SESSION['user']['id']]);
        } else {
            header('Location: /');
        }
    }
}
