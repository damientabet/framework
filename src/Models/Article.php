<?php

namespace App\Models;

use Core\Model\Model;

class Article extends Model
{
    /**
     * @return mixed
     */
    public function getAllArticles()
    {
        $query = 'SELECT a.`id_article`, a.`title`, a.`description`, a.`content`, a.`id_user`, a.`approved`,a.`date_add` AS "add_article", u.`firstname`, u.`lastname`  FROM `article` a 
                    LEFT JOIN `user` u
                    ON (a.`id_user` = u.`id_user`)
                    ORDER BY a.`id_article` DESC';
        return $this->database->results($query);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getArticleById(int $id)
    {
        $query = 'SELECT a.`id_article`, a.`title`, a.`description`, a.`content`, a.`id_user`, a.`approved`,a.`date_add` AS "add_article", u.`firstname`, u.`lastname` 
                    FROM `article` a 
                    LEFT JOIN `user` u 
                        ON (a.`id_user` = u.`id_user`) 
                    WHERE a.`id_article` = '. (int)$id;
        return $this->database->result($query);
    }

    /**
     * @param int $id
     * @param int $id_user
     * @return mixed
     */
    public function getArticleByIdUser(int $id, int $id_user)
    {
        $query = 'SELECT * FROM `article` WHERE `id_article` = '.(int)$id.' AND `id_user` = '.(int)$id_user;
        return $this->database->result($query);
    }
}
