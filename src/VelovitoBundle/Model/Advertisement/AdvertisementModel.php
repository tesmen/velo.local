<?php

namespace VelovitoBundle\Model\Advertisement;

use Doctrine\ORM\EntityManager;
use VelovitoBundle\C;
use VelovitoBundle\Entity\User;
use VelovitoBundle\Model\DocumentModel;
use VelovitoBundle\Entity\Advertisement;
use VelovitoBundle\Model\SecurityModel;
use VelovitoBundle\Service\FileWorker;

class AdvertisementModel
{
    private $em;
    private $documentModel;
    private $securityModel;
    private $fileWorker;

    private $categoriesRepo;

    public function __construct(EntityManager $em, DocumentModel $documentModel, SecurityModel $securityModel, FileWorker $fileWorker)
    {
        $this->em = $em;
        $this->documentModel = $documentModel;
        $this->securityModel = $securityModel;
        $this->fileWorker = $fileWorker;

        $this->categoriesRepo = $em->getRepository(C::REPO_CATALOG_CATEGORY);
        $this->currencyRepo = $this->em->getRepository(C::REPO_CURRENCY);
    }

    public function createNewAdvert(array $formData)
    {
        $user = $this->securityModel->getUser();
        $advert = new Advertisement();
        try {
            $this->em->beginTransaction();

            $currency = $this->currencyRepo->findOneOrFail(
                ['id' => 1]
            );

            if (!empty($formData[C::FORM_PHOTO])) {
                $this->fileWorker->saveUserUploadedFile($formData[C::FORM_PHOTO]);
            }

            $advert->setDescription($formData[C::FORM_DESCRIPTION])
                ->setUser($user)
                ->setIsDeleted(false)
                ->setIsPublished(true)
                ->setPrice($formData[C::FORM_PRICE])
                ->setCurrency($currency)
                ->setTitle($formData[C::FORM_TITLE]);

            $this->em->persist($advert);
            $this->em->flush($advert);
            $this->em->commit();
        } catch (\Exception $e) {
            $this->em->rollback();

            throw $e;
        }


        return $advert->getId();
    }

    public function getCategoriesForForm()
    {
        $result = [];

        $parentNodes = $this->categoriesRepo->findBy([
            'parent' => null,
        ]);

        foreach ($parentNodes as $parent) {
            $result['parents'][$parent->getName()] = $parent->getId();

            foreach ($parent->getCatalogItems() as $item) {
                $result['children'][$parent->getId()][$item->getName()] = $item->getId();
            }
        }

        return $result;
    }

    public function updateAdvert($advert, array $formData)
    {
        $photoRepo = $this->em->getRepository(C::REPO_PHOTO_FILE);
        if (!($advert instanceof Advertisement)) {
            $advert = $this->getAdvertById($advert);
        }

        $entData[C::FORM_CURRENCY] = $this->em->getRepository(C::REPO_CURRENCY)->find(1);
        $entData[C::FORM_TITLE] = $formData[C::FORM_TITLE];
        $entData[C::FORM_PRICE] = $formData[C::FORM_PRICE];
        $entData[C::FORM_DESCRIPTION] = $formData[C::FORM_DESCRIPTION];

        $savedFiles = $this->documentModel->saveOriginalsForUploadedImages($formData[C::FORM_PHOTO_FILENAMES]);
        $photoRepo->removeAllPhotosByAdvertId($advert->getId());

        foreach ($savedFiles as $fileName) {
            $photoRepo->create(
                [
                    'advert'   => $advert,
                    'fileName' => $fileName,
                ]
            );
        }


        return $this->em->getRepository(C::REPO_ADVERTISEMENT)->update($advert, $entData);
    }

    public function getAdsByUserId($userId)
    {
        return $this->em->getRepository(C::REPO_ADVERTISEMENT)->findBy(
            ['user' => $userId,],
            ['creationDate' => 'DESC']
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

    public function getFewLastAds()
    {
        return $this->em->getRepository(C::REPO_ADVERTISEMENT)->findBy(
            ['isPublished' => true],
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
        return $this->em->getRepository(C::REPO_ADVERTISEMENT)->findOneOrFail($id);
    }

    public function unpublishAdvert($advertId, $reason)
    {
        $repo = $this->em->getRepository(C::REPO_ADVERTISEMENT);

        $mapper = [
            C::FORM_SOLD_AT_VELOVITO => C::ADVERT_UNPUBLISH_REASON_SOLD_HERE,
            C::FORM_SOLD_SOMEWHERE   => C::ADVERT_UNPUBLISH_REASON_SOLD_SOMEWHERE,
            C::FORM_OTHER_REASON     => C::ADVERT_UNPUBLISH_REASON_OTHER,
        ];

        if (!isset($mapper[$reason])) {
            throw new \Exception(sprintf("undefined unpublish reason %s", $reason));
        }

        $repo->unPublish($advertId);
    }

    public function incrementViewed(Advertisement $ent)
    {
        $views = $ent->getViewsCount();
        $views++;
        $ent->setViewsCount($views);
        $this->em->flush($ent);
    }
}
