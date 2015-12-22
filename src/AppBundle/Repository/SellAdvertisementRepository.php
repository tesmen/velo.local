<?php

namespace AppBundle\Repository;

use AppBundle\Entity\BuyAdvertisement as BuyAds;

class SellAdvertisementRepository extends GeneralRepository
{
    public function create($data)
    {
        $ent = new BuyAds();

        $ent
            ->setTitle($data['title'])
            ->setPrice($data['price']);
    }
}
