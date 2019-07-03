<?php

namespace App\Controllers\front;

class ContactController extends FrontController
{
    /**
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        return $this->twig->display('contact.html.twig');
    }

    public function sendMail()
    {
        $firstname = (string)$_POST['firstname'];
        $lastname = (string)$_POST['lastname'];
        $subject = (string)$_POST['subject'];
        $email = (string)$_POST['email'];
        $message = (string)$_POST['message'];

        $templateVars = array(
            '{nom}' => (string)$firstname,
            '{prenom}' => (string)$lastname,
            '{email}' => (string)$email,
            '{message}' => (string)$message
        );

        $search = array_keys((array)$templateVars);
        $replace = array_values((array)$templateVars);

        $template = file_get_contents('../src/Views/front/mail/contact.html');

        $template = str_replace($search, $replace, $template);

        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=UTF-8';

        if (isset($_POST['mailsend'])) {
            if (!empty($firstname)
                && !empty($lastname)
                && !empty($email)
                && !empty($message)
            ) {
                if ($_POST['rgpd'] == 'on') {
                    mail('tabetdamien@free.fr', $subject, $template, implode("\r\n", $headers));
                    header('Location: /contact');
                }
            }
        }
    }
}
