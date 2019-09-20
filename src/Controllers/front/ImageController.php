<?php

namespace App\Controllers\front;

use Core\Model\ModelFactory;

class ImageController extends FrontController
{
    public function addUserImage(int $idy)
    {
        $extension = new \SplFileInfo($this->files['userImg']['name']);
        $extension = $extension->getExtension();
        $acceptExtension = ['jpg', 'png'];
        if (in_array($extension, $acceptExtension)) {
            $imgName = (int)$idy . '.' . $extension;
            $imgDirname = IMG_USER_DIR . $imgName;
            if (!file_exists(IMG_USER_DIR)) {
                mkdir(IMG_USER_DIR, 0777,true);
            }
            if (move_uploaded_file($this->files['userImg']['tmp_name'], $imgDirname)) {
                ModelFactory::get('User')->update($this->session['user']['id'], ['image_name' => $imgName], 'id_user');
                $this->redirect('/user/edit/' . (int)$idy);
            } else {
                return 'Erreur lors du téléchargement de l\'image';
            }
        }
        return 'L\'extension de l\'image n\'est pas correct : ' . $acceptExtension;
    }

    public function deleteUserImage(int $idy)
    {
        $user = ModelFactory::get('User')->read((int)$idy, 'id_user');
        ModelFactory::get('User')->update($this->session['user']['id'], ['image_name' => null], 'id_user');
        if (file_exists(IMG_USER_DIR.$user['image_name'])) {
            unlink(IMG_USER_DIR.$user['image_name']);
        }
    }
}
