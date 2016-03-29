<?php

namespace VelovitoBundle\Repository;


use VelovitoBundle\Entity\Country;

class CountryRepository extends GeneralRepository
{
    public function getEntity()
    {
        return new Country();
    }
}
