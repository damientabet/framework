<?php

namespace App\Models;

use Core\Model\Model;

class Article extends Model
{
    public function getAllArticles()
    {
        $query = 'SELECT * FROM `article` a 
                    LEFT JOIN `user` u
                    ON (a.`id_user` = u.`id_user`)
                    ORDER BY a.`id_article` DESC';
        return $this->database->results($query);
    }

    public function getArticleById($id)
    {
        $query = 'SELECT a.`id_article`, a.`title`, a.`content`, a.`id_user`, a.`date_add` AS "add_article", u.`firstname`, u.`lastname` 
                    FROM `article` a 
                    LEFT JOIN `user` u 
                        ON (a.`id_user` = u.`id_user`) 
                    WHERE a.`id_article` = '.$id;
        return $this->database->result($query);
    }

    public function getArticleByIdUser($id, $id_user)
    {
        $query = 'SELECT * FROM `article` WHERE `id_article` = '.$id.' AND `id_user` = '.$id_user;
        return $this->database->result($query);
    }
}
