<?php

namespace VelovitoBundle\Model\Advertisement;

use Doctrine\ORM\EntityManager;
use VelovitoBundle\C;
use VelovitoBundle\Entity\User;

class AdvertisementModel
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function createNewAd($formData, User $user)
    {
        return $this->em->getRepository(C::REPO_AD)->create($formData, $user);
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
