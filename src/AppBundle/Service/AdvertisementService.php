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
}

