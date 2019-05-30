<?php

namespace App\Models;

use Core\Model\Model;

class Comment extends Model
{
    public function getCommentsByArticle($id)
    {
        $query = 'SELECT c.`content`, c.`date_add`, c.`id_user`, u.`firstname`, u.`lastname` FROM `comment` c
                LEFT JOIN `user` u
                    ON (c.`id_user` = u.`id_user`)
                WHERE c.`id_article` = '.$id;
        return $this->database->results($query);
    }
}
