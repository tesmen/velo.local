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
        $a = $this->_em->getConnection()->createQueryBuilder()
            ->select('*')
            ->where('id = 1');

        $ent = $this->findOneOrFail($advertid);
        $ent->setIsPublished(false);
        $this->_em->flush($ent);

        return $ent;
    }

    public function test()
    {
        $a = $this->_em->getConnection()->createQueryBuilder()
            ->select('*')
            ->from('advertisement')
        ->execute()->fetchAll();

        return $a;
    }
}
