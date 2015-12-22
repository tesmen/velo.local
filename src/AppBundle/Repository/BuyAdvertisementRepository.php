<?php

namespace AppBundle\Repository;

use AppBundle\Entity\BuyAdvertisement as BuyAds;

class BuyAdvertisementRepository extends GeneralRepository
{
    public function create($data)
    {
        $ent = new BuyAds();

        $ent
            ->setTitle($data['title'])
            ->setPrice($data['price']);

        $this->_em->persist($ent);
        $this->_em->flush();
    }
}
