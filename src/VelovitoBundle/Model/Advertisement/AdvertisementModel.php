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
        return $this->em->getRepository(C::REPO_ADVERTISEMENT)->create($formData, $user);
    }

    public function getAdsByUserId($userId)
    {
        return $this->em->getRepository(C::REPO_ADVERTISEMENT)->findBy(
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

    public function getFewLastAds($limit = 15)
    {
        return $this->em->getRepository(C::REPO_ADVERTISEMENT)->findAll();
    }

    public function getAdStatusMap()
    {
        return $adStatusMap = [
            'Черновик'           => C::AD_STATUS_DRAFT,
            'Опубликовано'       => C::AD_STATUS_PUBLISHED,
            'Снято с публикации' => C::AD_STATUS_DELETED,
        ];
    }

    public function getAdById($id)
    {
        return $this->em->getRepository(C::REPO_ADVERTISEMENT)->findOneOrFail(
            [
                'id' => $id,
            ]
        );
    }
}
