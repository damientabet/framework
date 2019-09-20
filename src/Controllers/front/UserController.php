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

            if (empty($this->post['firstname']) || !preg_match('#^[a-zA-Z]+$#',$this->post['firstname'])) {
                $this->errors[] = 'Le prénom est invalide';
            } elseif (empty($this->post['lastname']) || !preg_match('#^[a-zA-Z]+$#',$this->post['lastname'])) {
                $this->errors[] = 'Le nom est invalide';
            } elseif (empty($this->post['email']) && preg_match('#^\w+@\w+.\w{2,3}#',$this->post['email'])) {
                $this->errors[] = 'Une erreur est survenue au niveau de l\'adresse email';
            } elseif (empty($this->post['password'])) {
                $this->errors[] = 'No password';
            } else {
                $data = [
                    'lastname' => (string)$this->post['lastname'],
                    'firstname' => (string)$this->post['firstname'],
                    'email' => (string)filter_var($this->post['email'], FILTER_VALIDATE_EMAIL),
                    'password' => password_hash($this->post['password'], PASSWORD_DEFAULT),
                    'image_name' => 'default.png',
                    'date_add' => date('Y-m-d H:i:s'),
                    'date_upd' => date('Y-m-d H:i:s')
                ];
                ModelFactory::get('User')->create((array)$data);

                $user = ModelFactory::get('User')->read($data['email'], 'email');
                $this->session['user'] = [
                    'id' => (string)$user['id_user'],
                    'lastname' => (string)$user['lastname'],
                    'firstname' => (string)$user['firstname'],
                    'email' => (string)$user['email']
                ];
                $this->redirect('/user/' . $this->session['user']['id']);
            }

            if ($this->errors) {
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
                $image = new ImageController();
                $image->deleteUserImage((int)$idy);
            }
            if (isset($this->post['updateUser'])) {
                // Ajout de l'image
                if (isset($this->files['userImg'])) {
                    $image = new ImageController();
                    $image->addUserImage((int)$idy);
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
                $image = new ImageController();
                $image->deleteUserImage((int)$idy);
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
