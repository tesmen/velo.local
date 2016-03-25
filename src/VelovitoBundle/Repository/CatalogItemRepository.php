<?php

namespace VelovitoBundle\Repository;

use VelovitoBundle\Entity\CatalogItem;
use VelovitoBundle\C;

class CatalogItemRepository extends GeneralRepository
{
    public function create(array $data)
    {
        $ent = $this->getNewEntity($data);

        $this->_em->persist($ent);
        $this->_em->flush($ent);
    }

    public function getNewEntity(array $data)
    {
        $ent = new CatalogItem();
        $ent
            ->setId($data['id'])
            ->setName($data['name'])
            ->setCategory($data['category'])
            ->setAlias($data['alias']);

        return $ent;
    }
}
