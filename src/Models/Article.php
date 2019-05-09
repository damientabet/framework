<?php

namespace App\Models;

use Core\Model\Model;

class Article extends Model
{
    public function getAllArticles()
    {
        $query = 'SELECT * FROM `article` a
                LEFT JOIN `user` u
                    ON (a.`id_user` = u.`id`)';
        return $this->database->results($query);
    }

    public function getArticleByIdUser($id, $id_user)
    {
        $query = 'SELECT * FROM `article` WHERE `id` = '.$id.' AND `id_user` = '.$id_user;
        return $this->database->result($query);
    }
}
