<?php

namespace AppBundle\Model;

use AppBundle\C;
use AppBundle\Entity\Ad;

class AdvertisementModel
{
    private $em;

    public function __construct($em)
    {
        $this->em = $em;
    }

    public function createAd($formsData)
    {
        $repo = $this->em->getRepository(C::REPO_AD);
        $repo->create(
            [
                'title' => $formsData[C::FORM_TITLE],
                'price' => $formsData[C::FORM_PRICE],
            ]
        );
    }

    public function getAllAds()
    {
        $ads = $this->em->getRepository(C::REPO_AD)->findAll();

        foreach ($ads as $ad) {
            $result[] = new Ad($ad);
        }

        return $ads;
    }

    public function getAdById($adId)
    {
        return $this->em->getRepository(C::REPO_AD)->findOneById($adId);
    }
}
