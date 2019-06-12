<?php

namespace App\Controllers\front;

use App\Controllers\Controller;
use Core\Model\ModelFactory;
use Twig\Loader\FilesystemLoader;

class FrontController extends Controller
{
    public function __construct()
    {
        $loader = new FilesystemLoader('./../src/Views/front');
        parent::__construct($loader);
    }

    public function authentification()
    {
        $this->connectionUser();
        $this->createUser();

        echo $this->twig->render('front/authentification.html.twig',
            [
                'errors' => $this->errors
            ]);
    }

    public function connectionUser()
    {
        if (isset($_POST['connection'])) {
            $email = $_POST['connection_email'];
            $user = ModelFactory::get('User')->read($email, 'email');
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
                    header('Location: /user/' . $_SESSION['user']['id']);
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
