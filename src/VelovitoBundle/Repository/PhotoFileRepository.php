<?php

namespace VelovitoBundle\Repository;

use VelovitoBundle\Entity\PhotoFile;

class PhotoFileRepository extends GeneralRepository
{

    public function getEntity()
    {
        return new PhotoFile();
    }

    public function removeAllPhotosByAdvertId($advertId)
    {
        foreach ($this->findBy(['advert' => $advertId]) as $ent) {
            $this->_em->remove($ent);
        }

        $this->_em->flush();
    }
}
