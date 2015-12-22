<?php

namespace AppBundle\Service;

use AppBundle\Model\BuyAd;
use AppBundle\Model\SellAd;

class AdvertisementService
{
    private $em;

    public function __construct($em)
    {
        $this->em = $em;
    }

    public function createAd()
    {
        $repo = $this->em->getRepository('AppBundle:BuyAdEnt');
        $repo->create(
            [
                'title' => 'tiiitle',
                'price' => rand(0,100),
            ]
        );
    }

    public function getAllAds()
    {
        $buyAds = $this->em->getRepository('AppBundle:BuyAdEnt')->findAll();
        $sellAds = $this->em->getRepository('AppBundle:SellAdEnt')->findAll();

        foreach (array_merge($buyAds, $sellAds) as $ad){
            $result[] = new BuyAd($ad);
        }

        return $result;
    }
}

