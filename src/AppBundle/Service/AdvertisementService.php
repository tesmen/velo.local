<?php

namespace AppBundle\Service;

use AppBundle\Model\Ad;
use AppBundle\C;

class AdvertisementService
{
    private $em;

    public function __construct($em)
    {
        $this->em = $em;
    }

    public function createAd($formsData)
    {
        $repo = $this->em->getRepository('AppBundle:AdEnt');
        $repo->create(
            [
                'title' => $formsData[C::FORM_TITLE],
                'price' => $formsData[C::FORM_PRICE],
            ]
        );
    }

    public function getAllAds()
    {
        $ads = $this->em->getRepository('AppBundle:AdEnt')->findAll();

        foreach ($ads as $ad) {
            $result[] = new Ad($ad);
        }

        return $ads;
    }

    public function getFormsDataForNewAd()
    {
        return null;
    }
}

