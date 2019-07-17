<?php

namespace App\Controllers\front;

use Core\Model\ModelFactory;

class UserController extends FrontController
{
    public $errors = [];

    /**
     * @param int $idy
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function userIndex(int $idy)
    {
        $user = ModelFactory::get('User')->read((int)$idy, 'id_user');
        if (isset($this->session['user'])) {
            return $this->twig->display('user/account.html.twig', [
                    "user" => $user]);
        }
        $this->redirect('/');
    }

    /**
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function authentification()
    {
        $this->createUser();

        return $this->twig->display('authentification.html.twig', [
                'errors' => $this->errors]);
    }

    /**
     * @return array
     */
    public function createUser()
    {
        if (isset($this->post['addUser'])) {

            if (empty($this->post['lastname'])) {
                $this->errors[] = 'No lastname';
            }
            if (empty($this->post['firstname'])) {
                $this->errors[] = 'No firstname';
            }
            if (empty($this->post['email'])) {
                $this->errors[] = 'No email';
            }
            if (empty($this->post['password'])) {
                $this->errors[] = 'No password';
            }

            if (!$this->errors) {
                $data = [
                    'lastname' => (string)$this->post['lastname'],
                    'firstname' => (string)$this->post['firstname'],
                    'email' => (string)$this->post['email'],
                    'password' => password_hash($this->post['password'], PASSWORD_DEFAULT),
                    'image_name' => 'default.png',
                    'date_add' => date('Y-m-d H:i:s'),
                    'date_upd' => date('Y-m-d H:i:s')
                ];
                ModelFactory::get('User')->create((array)$data);

                $user = ModelFactory::get('User')->read($data['email'], 'email');
                // TODO : A checker !
                // $session = $this->session['user']['id'];
                $this->session['user'] = [
                    'id' => (string)$user['id_user'],
                    'lastname' => (string)$user['lastname'],
                    'firstname' => (string)$user['firstname'],
                    'email' => (string)$user['email']
                ];
                $this->redirect('/user/' . $this->session['user']['id']);
            } else {
                return $this->errors;
            }
        }
    }

    /**
     * @param int $idy
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError(string)
     */
    public function updateUser(int $idy)
    {
        if (isset($this->session['user'])) {
            if (isset($this->post['deleteImg'])) {
                $user = ModelFactory::get('User')->read((int)$idy, 'id_user');
                ModelFactory::get('User')->update($this->session['user']['id'], ['image_name' => null], 'id_user');
                unlink('../public/img/user/'.$user['image_name']);
            }

            if (isset($this->post['updateUser'])) {
                // Ajout de l'image
                if (isset($this->files['userImg'])) {
                    $extension = new \SplFileInfo($this->files['userImg']['name']);
                    $extension = $extension->getExtension();
                    $acceptExtension = ['jpg', 'png'];
                    if (in_array($extension, $acceptExtension)) {
                        $imgName = (int)$idy . '.' . $extension;
                        $imgDirname = IMG_USER_DIR.$imgName;
                        if (move_uploaded_file($this->files['userImg']['tmp_name'], $imgDirname)) {
                            ModelFactory::get('User')->update($this->session['user']['id'], ['image_name' => $imgName], 'id_user');
                            $this->redirect('/user/edit/'.(int)$idy);
                        } else {
                            return 'Erreur lors du téléchargement de l\'image';
                        }
                    }
                    return 'L\'extension de l\'image n\'est pas correct : '.$acceptExtension;
                }
                $data = [
                    'firstname' => (string)$this->post['firstname'],
                    'lastname' => (string)$this->post['lastname'],
                    'email' => (string)$this->post['email'],
                    'date_upd' => date('Y-m-d H:i:s')
                ];

                ModelFactory::get('User')->update($this->session['user']['id'], $data, 'id_user');
            }

            $user = ModelFactory::get('User')->read($this->session['user']['id'], 'id_user');

            return $this->twig->display('user/edit.html.twig', [
                    "user" => $user]);
        }

        $this->redirect('/');
    }

    /**
     * @param int $idy
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function deleteUser(int $idy)
    {
        if (isset($this->session['user'])) {
            if (isset($this->post['deleteUser'])) {
                $user = ModelFactory::get('User')->read((int)$idy, 'id_user');
                unlink('../public/img/user/'.$user['image_name']);
                ModelFactory::get('Article')->delete((int)$this->session['user']['id'], 'id_user');
                if (ModelFactory::get('User')->delete((int)$this->session['user']['id'])) {
                    $this->logout();
                    $this->redirect('/');
                }
            }
            return $this->twig->display('user/delete.html.twig', ['user_id' => (int)$this->session['user']['id']]);
        }
        $this->redirect('/');
    }
}
