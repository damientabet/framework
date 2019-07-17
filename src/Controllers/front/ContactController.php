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
        $firstname = (string)$this->post['firstname'];
        $lastname = (string)$this->post['lastname'];
        $subject = (string)$this->post['subject'];
        $email = (string)$this->post['email'];
        $message = (string)$this->post['message'];

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

        if (isset($this->post['mailsend'])) {
            if (!empty($firstname)
                && !empty($lastname)
                && !empty($email)
                && !empty($message)
            ) {
                if ($this->post['rgpd'] == 'on') {
                    mail('tabetdamien@free.fr', $subject, $template, implode("\r\n", $headers));
                    $this->redirect('/contact');
                }
            }
        }
    }
}
