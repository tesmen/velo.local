<?php

namespace VelovitoBundle\Model\Advertisement;

use Doctrine\ORM\EntityManager;
use VelovitoBundle\C;
use VelovitoBundle\Entity\Product;
use VelovitoBundle\Entity\ProductAttribute;
use VelovitoBundle\Entity\ProductAttributeMap;
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

        $this->advertRepo = $this->em->getRepository(C::REPO_ADVERTISEMENT);
        $this->categoriesRepo = $em->getRepository(C::REPO_PRODUCT_CATEGORY);
        $this->userPhotoRepo = $this->em->getRepository(C::REPO_USER_PHOTO);
        $this->productRepo = $this->em->getRepository(C::REPO_PRODUCT);
        $this->productAttrRepo = $this->em->getRepository(C::REPO_PRODUCT_ATTRIBUTE);
        $this->productAttrMapRepo = $this->em->getRepository(C::REPO_PRODUCT_ATTRIBUTE_MAP);
    }

    /**
     * @param $productId
     * @return Product
     * @throws \VelovitoBundle\Exception\NotFoundException
     */
    public function getProductById($productId)
    {
        return $this->productRepo->findOneOrFail(
            ['id' => $productId,]
        );
    }


    /**
     * @param $productId
     * @return ProductAttribute[]
     * todo refactor for performance issues
     */
    public function getAttributesByProductId($productId)
    {
        $mappings = $this->productAttrMapRepo->findBy([
            'productId' => $productId,
        ]);

        $result = [];

        foreach ($mappings as $map) {
            $result[] = $this->productAttrRepo->findOneOrFail([
                'id' => $map->getAttribute()->getId(),
            ]);
        }

        return $result;
    }


    /**
     * @param $productId
     * @return \VelovitoBundle\Entity\ProductCategory
     */
    public function getCategoryByProductId($productId)
    {
        $product = $this->getProductById($productId);

        return $product->getCategory();
    }

    public function createNewAdvert(array $formData, Advertisement $oldAdvert = null)
    {
        $user = $this->securityModel->getUser();
        $advert = $oldAdvert ? $oldAdvert : new Advertisement();
        $this->em->beginTransaction();
        $category = $this->getCategoryByProductId($formData[C::FORM_PRODUCT]);
        $product = $this->getProductById($formData[C::FORM_PRODUCT]);

        try {
            $advert->setDescription($formData[C::FORM_DESCRIPTION])
                ->setUser($user)
                ->setIsDeleted(false)
                ->setIsPublished(true)
                ->setCurrency($formData[C::FORM_CURRENCY])
                ->setPrice($formData[C::FORM_PRICE])
                ->setCurrency($formData[C::FORM_CURRENCY])
                ->setProduct($product)
                ->setProductCategory($category)
                ->setTitle($formData[C::FORM_TITLE]);

            if (!empty($formData[C::FORM_PHOTO])) {
                $photoFileName = $this->fileWorker->saveUserUploadedPhoto($formData[C::FORM_PHOTO]);
                $userPhoto = $this->userPhotoRepo->create($user, $photoFileName);
                $advert->setPhoto($userPhoto);
            }

            $this->em->persist($advert);
            $this->em->flush($advert);
            $this->em->commit();
        } catch (\Exception $e) {
            $this->em->rollback();

            throw $e;
        }

        return $advert->getId();
    }

    public function getProductListWithCategoriesForForm()
    {
        $result = [];
        $select = $this->categoriesRepo->getProductsWithCategories();

        foreach ($select as $row) {
            $result[$row['category_name']][$row['name']] = $row['id'];
        }

        return $result;
    }


    public function getAdsByUserId($userId)
    {
        return $this->advertRepo->findBy(
            ['user' => $userId,],
            ['creationDate' => 'DESC']
        );
    }

    public function getFavoriteAdsByUserId($userId)
    {
        return $this->em->getRepository(C::REPO_USER_FAVORITES)->findBy(
            [
                'user' => $userId,
            ]
        );
    }

    public function getLastAdverts()
    {
        return $this->advertRepo->findBy(
            ['isPublished' => true],
            ['creationDate' => 'DESC']
        );
    }


    public function getLastAdvertsFromCategory($id)
    {
        $category = $this->em->getReference(C::REPO_PRODUCT_CATEGORY, $id);

        return $this->advertRepo->findBy(
            [
                'productCategory' => $category,
                'isPublished'     => true,
            ],
            ['creationDate' => 'DESC']
        );
    }


    public function getLastAdvertsOfProduct($id)
    {
        $product = $this->em->getReference(C::REPO_PRODUCT, $id);

        return $this->advertRepo->findBy(
            [
                'product'     => $product,
                'isPublished' => true,
            ],
            ['creationDate' => 'DESC']
        );
    }

    /**
     * @param $params
     * @return array|\VelovitoBundle\Entity\Advertisement[]
     * @throws \Doctrine\ORM\ORMException
     * TODO unfinished
     */
    public function searchAdverts($params)
    {
        $category = $this->em->getReference(C::REPO_PRODUCT_CATEGORY, $id);

        return $this->advertRepo->findBy(
            [
                'productCategory' => $category,
                'isPublished'     => true,
            ],
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
        return $this->advertRepo->findOneOrFail($id);
    }

    /**
     * @param $id
     * @return Advertisement
     * @throws \VelovitoBundle\Exception\NotFoundException
     */
    public function getAdvertArrayById($id)
    {
        return $this->advertRepo->findOneOrFail($id);
    }

    public function unpublishAdvert($advertId, $reason)
    {
        $repo = $this->advertRepo;

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

    public function userCanEditAdvert(Advertisement $ent)
    {
        $currentUser = $this->securityModel->getUser();

        if ($currentUser->getRole() === C::ROLE_ADMIN) {
            return true;
        }

        return $currentUser->getId() === $ent->getUser()->getId();
    }

    public function createAdvertAttributeMap(array $data)
    {
        $this->em->beginTransaction();
        try {
            foreach ($data as $formFieldName => $value) {
                if (!preg_match('/^' . ProductAttribute::FORM_PREFIX . '([0-9]+)/', $formFieldName, $matches)) {
                    continue;
                }
            }
            $map = new ProductAttributeMap();
            $map->setProductId()
                ->setAttribute();


            $this->em->persist($map);
            $this->em->flush($map);
            $this->em->commit();
        } catch (\Exception $e) {
            $this->em->rollback();

            throw $e;
        }
    }
}
