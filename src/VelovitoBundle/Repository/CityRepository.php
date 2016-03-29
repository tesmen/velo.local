<?php

namespace VelovitoBundle\Repository;


use VelovitoBundle\Entity\City;

class CityRepository extends GeneralRepository
{
    public function getEntity()
    {
        return new City();
    }
}
