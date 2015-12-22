<?php

namespace AppBundle\Repository;

use AppBundle\Entity\BuyAdEnt;

class BuyAdRepository extends GeneralRepository
{
    public function create($data)
    {
        $ent = new BuyAdEnt();

        $ent
            ->setTitle($data['title'])
            ->setPrice($data['price']);

        $this->_em->persist($ent);
        $this->_em->flush();
    }
}
