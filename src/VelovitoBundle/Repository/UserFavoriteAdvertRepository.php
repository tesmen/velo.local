<?php

namespace VelovitoBundle\Repository;

use VelovitoBundle\Entity\Advertisement;
use VelovitoBundle\Entity\UserFavoriteAdvert;
use VelovitoBundle\Entity\User;

class UserFavoriteAdvertRepository extends GeneralRepository
{
    public function getEntity()
    {
        return new UserFavoriteAdvert();
    }
}
