<?php

namespace App\Controllers\front;

class ContactController extends FrontController
{
    public function index()
    {
        echo $this->twig->render('contact.html.twig');
    }

    public function sendMail()
    {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $subject = $_POST['subject'];
        $email = $_POST['email'];
        $message = $_POST['message'];

        $templateVars = array(
            '{nom}' => $firstname,
            '{prenom}' => $lastname,
            '{email}' => $email,
            '{message}' => $message
        );

        $search = array_keys($templateVars);
        $replace = array_values($templateVars);

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
