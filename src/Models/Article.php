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
        return $this->database->getAll($query);
    }

    /**
     * @param int $id_article
     * @return mixed
     */
    public function getArticleById(int $id_article)
    {
        $query = 'SELECT a.`id_article`, a.`title`, a.`description`, a.`content`, a.`id_user`, a.`approved`,a.`date_add` AS "add_article", u.`firstname`, u.`lastname` 
                    FROM `article` a 
                    LEFT JOIN `user` u 
                        ON (a.`id_user` = u.`id_user`) 
                    WHERE a.`id_article` = '. (int)$id_article;
        return $this->database->get($query);
    }

    /**
     * @param int $id_article
     * @param int $id_user
     * @return mixed
     */
    public function getArticleByIdUser(int $id_article, int $id_user)
    {
        $query = 'SELECT * FROM `article` WHERE `id_article` = '.(int)$id_article.' AND `id_user` = '.(int)$id_user;
        return $this->database->get($query);
    }

    /**
     * @param int $id_user
     * @return mixed
     */
    public function getArticlesByIdUser(int $id_user)
    {
        $query = 'SELECT * FROM `article` WHERE `id_user` = '.(int)$id_user;
        return $this->database->getAll($query);
    }

    /**
     * @return mixed
     */
    public function getNotApprovedArticles()
    {
        $query = 'SELECT * FROM `article` WHERE `approved` = 0 ORDER BY `id_article` DESC';
        return $this->database->getAll($query);
    }

    public function getTwoLastArticles()
    {
        $query = 'SELECT a.`id_article`, a.`title`, a.`description`, a.`content`, a.`id_user`, a.`approved`,a.`date_add` AS "add_article", u.`firstname`, u.`lastname`  FROM `article` a 
                    LEFT JOIN `user` u
                    ON (a.`id_user` = u.`id_user`)
                    WHERE a.`approved` = 1
                    ORDER BY a.`id_article` DESC
                    LIMIT 0,2';
        return $this->database->getAll($query);
    }

    public function getArticles()
    {
        $query = 'SELECT a.`id_article`, a.`title`, a.`description`, a.`content`, a.`id_user`, a.`approved`,a.`date_add` AS "add_article", u.`firstname`, u.`lastname`  FROM `article` a 
                    LEFT JOIN `user` u
                    ON (a.`id_user` = u.`id_user`)
                    WHERE a.`approved` = 1
                    ORDER BY a.`id_article` DESC
                    LIMIT 2,10';
        return $this->database->getAll($query);
    }
}
