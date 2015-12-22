<?php

namespace AppBundle\Service;

use AppBundle\Model\Ad;

class AdvertisementService
{
    private $em;

    public function __construct($em)
    {
        $this->em = $em;
    }

    public function createAd()
    {
        $repo = $this->em->getRepository('AppBundle:AdEnt');
        $repo->create(
            [
                'title' => 'tiiitle',
                'price' => rand(0,100),
            ]
        );
    }

    public function getAllAds()
    {
        $ads = $this->em->getRepository('AppBundle:AdEnt')->findAll();

        foreach ($ads as $ad){
            $result[] = new Ad($ad);
        }

        return $ads;
    }
}

