<?php

namespace VelovitoBundle\Repository;

use VelovitoBundle\Entity\Photo;

class PhotoFileRepository extends GeneralRepository
{

    public function getEntity()
    {
        return new Photo();
    }

    public function removeAllPhotosByAdvertId($advertId)
    {
        foreach ($this->findBy(['advert' => $advertId]) as $ent) {
            $this->_em->remove($ent);
        }

        $this->_em->flush();
    }
}
