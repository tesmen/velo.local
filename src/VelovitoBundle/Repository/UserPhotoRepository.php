<?php

namespace VelovitoBundle\Repository;

use VelovitoBundle\Entity\UserPhoto;
use VelovitoBundle\Entity\User;

class UserPhotoRepository extends GeneralRepository
{
    /**
     * @param User $user
     * @param $filename
     * @return UserPhoto
     */
    public function create(User $user, $filename)
    {
        $ent = new UserPhoto();
        $ent
            ->setUser($user)
            ->setFileName($filename);

        $this->_em->persist($ent);
        $this->_em->flush($ent);

        return $ent;
    }
}
