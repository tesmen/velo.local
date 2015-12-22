<?php

namespace AppBundle\Repository;

use AppBundle\Entity\AdEnt;

class AdRepository extends GeneralRepository
{
    public function create($data)
    {
        $ent = new AdEnt();

        $ent
            ->setTitle($data['title'])
            ->setPrice($data['price']);

        $this->_em->persist($ent);
        $this->_em->flush();
    }
}
