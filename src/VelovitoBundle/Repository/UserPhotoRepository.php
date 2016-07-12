<?php

namespace VelovitoBundle\Repository;

use VelovitoBundle\Entity\UserPhoto;
use VelovitoBundle\Entity\User;

class UserPhotoRepository extends GeneralRepository
{
    public function create(User $user, $filename)
    {
        $ent = new UserPhoto();
        $ent
            ->setUser($user)
            ->setFileName($filename);
    }
}
