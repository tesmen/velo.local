<?php

namespace VelovitoBundle\Repository;

use VelovitoBundle\Entity\City;
use VelovitoBundle\Entity\Product;

class ProductRepository extends GeneralRepository
{
    public function create($name)
    {
        $ent = new Product();

        $ent
            ->setIsDeleted(false)
            ->setName($name);

        $this->_em->persist($ent);
        $this->_em->flush($ent);
    }
}
