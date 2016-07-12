<?php

namespace VelovitoBundle\Repository;

use VelovitoBundle\Entity\Advertisement;
use VelovitoBundle\Entity\UserPhoto;
use VelovitoBundle\Entity\User;
use VelovitoBundle\C;
use VelovitoBundle\Exception\NotFoundException;

class AdvertisementRepository extends GeneralRepository
{
    /**
     * @param array $data
     * @throws \Exception
     * @deprecated
     */
    public function load(array $data)
    {
        $this->_em->beginTransaction();

        try {
            foreach ($data as $id => $roleName) {
                $ent = new Advertisement();
                $ent->setId($id);
                $ent->setName($roleName);

                $this->_em->persist($ent);
            }

            $this->truncateTable();
            $this->_em->flush();
            $this->_em->commit();
        } catch (\Exception $e) {
            $this->_em->rollback();
            throw $e;
        }
    }

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
