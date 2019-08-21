<?php

namespace App\Models;

use Core\Model\Model;

class Comment extends Model
{
    /**
     * @param int $id
     * @return mixed
     */
    public function getCommentsByArticle(int $id)
    {
        $query = 'SELECT c.`id_comment`, c.`content`, c.`date_add`, c.`id_user`, u.`firstname`, u.`lastname`, c.`approved`, c.`id_article` FROM `comment` c
                LEFT JOIN `user` u
                    ON (c.`id_user` = u.`id_user`)
                WHERE c.`id_article` = '.(int)$id;
        return $this->database->results($query);
    }

    /**
     * @return mixed
     */
    public function getAllComments()
    {
        $query = 'SELECT c.`id_comment`, c.`content`, c.`date_add`, c.`id_user`, u.`firstname`, u.`lastname`, a.`title`, c.`approved`, c.`id_article` FROM `comment` c
                LEFT JOIN `user` u
                    ON (c.`id_user` = u.`id_user`)
                LEFT JOIN `article` a
                    ON (c.`id_article` = a.`id_article`)';
        return $this->database->results($query);
    }

    public function getCommentsByUser(int $id)
    {
        $query = 'SELECT * FROM `comment` 
                WHERE `id_user` = '.$id;
        return $this->database->results($query);
    }

    public function getNotApprovedComments()
    {
        $query = 'SELECT * FROM `comment`
                WHERE `approved` = 0';
        return $this->database->results($query);
    }
}
