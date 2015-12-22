<?php

namespace AppBundle\Model;

class BuyAdvertisement extends Advertisement
{
    private $em;

    public function __construct($ent)
    {
        $this->em = $ent;
    }
}

