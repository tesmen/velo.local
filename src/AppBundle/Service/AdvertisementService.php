<?php

namespace AppBundle\Service;

class AdvertisementService
{
    private $em;

    public function __construct($em)
    {
        $this->em = $em;
    }

    public function createAds()
    {
        $repo = $this->em->getRepository('AppBundle:BuyAdEnt');
        $repo->create(
            [
                'title' => 'tiiitle',
                'price' => rand(0,100),
            ]
        );
    }
}

