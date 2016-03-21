<?php

namespace VelovitoBundle\Repository;


use VelovitoBundle\Entity\AdvertStatus;

class AdvertStatusRepository extends GeneralRepository
{
    public function load(array $records)
    {
        $this->_em->beginTransaction();

        foreach ($records as $data) {
            $ent = $this->getEntity($data);
            $this->_em->persist($ent);
        }

        $this->_em->flush();
        $this->_em->getConnection()->commit();
    }

    public function create(array $data)
    {
        $ent = $this->getNewEntity($data);

        $this->_em->persist($ent);
        $this->_em->flush($ent);
    }

    public function getEntity(array $data)
    {
        if (!$ent = $this->find($data['id'])) {
            return $this->getNewEntity($data);
        }

        return $ent;
    }

    public function getNewEntity(array $data)
    {
        $ent = new AdvertStatus();
        $ent
            ->setId($data['id'])
            ->setName($data['name'])
            ->setAlias($data['alias']);

        return $ent;
    }
}

