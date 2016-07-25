<?php

namespace VelovitoBundle\Repository;

use VelovitoBundle\Exception\NotFoundException;

class AdvertisementRepository extends GeneralRepository
{
    /**
     * @param $advertid
     * @return null|object
     * @throws NotFoundException
     * @todo DQL!
     */
    public function unPublish($advertid)
    {
        $ent = $this->findOneOrFail($advertid);
        $ent->setIsPublished(false);
        $this->_em->flush($ent);

        return $ent;
    }
}
