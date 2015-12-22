<?php

namespace AppBundle\Service;

use AppBundle\Model\SellAdvertisement;
use AppBundle\Model\BuyAdvertisement;

class AdvertisementService
{
    private $em;

    public function __construct($em)
    {
        $this->em = $em;
    }

    public function createAds()
    {
        $repo = $this->em->getRepository('AppBundle:BuyAdvertisement');
        $repo->create(
            [
                'title' => 'tiiitle',
                'price' => 100,
            ]
        );
    }
}

