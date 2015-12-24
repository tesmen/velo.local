<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Ad;

class AdRepository extends GeneralRepository
{
    public function create($data)
    {
        $ent = new Ad;

        $ent
            ->setTitle($data['title'])
            ->setPrice($data['price']);

        $this->_em->persist($ent);
        $this->_em->flush();
    }
}
