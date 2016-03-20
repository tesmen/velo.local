<?php

namespace VelovitoBundle\Model\Advertisement;

use Doctrine\ORM\EntityManager;
use VelovitoBundle\C;
use VelovitoBundle\Entity\Advertisement;
use VelovitoBundle\Entity\User;
use VelovitoBundle\Model\DocumentModel;

class AdvertisementModel
{
    private $em;

    public function __construct(EntityManager $em, DocumentModel $documentModel)
    {
        $this->em = $em;
        $this->documentModel = $documentModel;
    }

    public function createNewAd(array $formData, User $user)
    {
        $savedFiles = $this->documentModel->saveOriginalsForUploadedImages($formData[C::FORM_PHOTO_FILENAMES]);
        $formData[C::FORM_PHOTO_FILENAMES] = $savedFiles;

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
        return $this->em->getRepository(C::REPO_ADVERTISEMENT)->findBy(
            [],
            ['creationDate' => 'DESC']
        );
    }

    public function getAdStatusMap()
    {
        return $adStatusMap = [
            'Черновик'           => C::ADVERT_STATUS_DRAFT,
            'Опубликовано'       => C::ADVERT_STATUS_PUBLISHED,
            'Снято с публикации' => C::ADVERT_STATUS_DELETED,
        ];
    }

    /**
     * @param $id
     * @return Advertisement
     * @throws \VelovitoBundle\Exception\NotFoundException
     */
    public function getAdvertById($id)
    {
        return $this->em->getRepository(C::REPO_ADVERTISEMENT)->findOneOrFail(
            [
                'id' => $id,
            ]
        );
    }

    public function incrementViewed(Advertisement $ent)
    {
        $views = $ent->getViewsCount();
        $views++;
        $ent->setViewsCount($views);
        $this->em->flush($ent);
    }

    public function updateAdvert($advert, array $data)
    {
        if (!($advert instanceof Advertisement)) {
            $advert = $this->getAdvertById($advert);
        }

        return $this->em->getRepository(C::REPO_ADVERTISEMENT)->update($advert, $data);
    }
}
