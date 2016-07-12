<?php

namespace VelovitoBundle\Repository;

use VelovitoBundle\Entity\UserPhoto;

class PhotoFileRepository extends GeneralRepository
{

    public function getEntity()
    {
        return new UserPhoto();
    }

    public function removeAllPhotosByAdvertId($advertId)
    {
        foreach ($this->findBy(['advert' => $advertId]) as $ent) {
            $this->_em->remove($ent);
        }

        $this->_em->flush();
    }
}
