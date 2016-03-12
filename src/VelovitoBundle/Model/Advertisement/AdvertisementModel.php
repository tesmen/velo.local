<?php

namespace VelovitoBundle\Model\Advertisement;

use Doctrine\ORM\EntityManager;
use VelovitoBundle\C;

class AdvertisementModel
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getAdsByUserId($userId)
    {
        return $this->em->getRepository(C::REPO_AD)->findBy(
            [
                'user' => $userId,
            ]
        );
    }

    public function getFavoritedAdsByUserId($userId)
    {
        return $this->em->getRepository(C::REPO_USER_FAVORITES)->findBy(
            [
                'user' => $userId,
            ]
        );
    }
}
