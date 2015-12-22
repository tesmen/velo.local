<?php

namespace AppBundle\Repository;

use AppBundle\Entity\BuyAdEnt as BuyAds;

class SellAdRepository extends GeneralRepository
{
    public function create($data)
    {
        $ent = new BuyAds();

        $ent
            ->setTitle($data['title'])
            ->setPrice($data['price']);
    }
}
