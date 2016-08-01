<?php

namespace VelovitoBundle\Model\Admin;

use Doctrine\ORM\EntityManager;
use VelovitoBundle\C;
use VelovitoBundle\Entity\Product;
use VelovitoBundle\Entity\ProductAttribute;
use VelovitoBundle\Entity\ProductCategory;

class AdminModel
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;

        $this->productsRepo = $em->getRepository(C::REPO_PRODUCT);
        $this->productsAttrRepo = $em->getRepository(C::REPO_PRODUCT_ATTRIBUTE);
        $this->productsAttrReferenceRepo = $em->getRepository(C::REPO_ATTRIBUTE_REFERENCE);
        $this->productCatRepo = $em->getRepository(C::REPO_PRODUCT_CATEGORY);
    }

    /**
     * @return Product[]
     */
    public function getAllProducts()
    {
        return $this->productsRepo->findAll();
    }

    /**
     * @return ProductCategory[]
     */
    public function getAllCategories()
    {
        return $this->productCatRepo->findAll();
    }

    /**
     * @return ProductAttribute[]
     */
    public function getAllAttributes()
    {
        return $this->productsAttrRepo->findAll();
    }

    /**
     * @return array
     */
    public function getAllAttributeReferences()
    {
        return $this->em->getRepository(C::REPO_ATTRIBUTE_REFERENCE)->findAll();
    }

    /**
     * @param $id
     * @return ProductAttribute[]
     */
    public function getProductAttributesByProductId($id)
    {
        return $this->productsAttrRepo->findby(
            ['productId' => $id]
        );
    }

    /**
     * @param $id
     * @return Product
     * @throws \VelovitoBundle\Exception\NotFoundException
     */
    public function getProductById($id)
    {
        return $this->productsRepo->findOneOrFail(['id' => $id]);
    }

    /**
     *
     * @param $id
     * @return ProductCategory
     * @throws \VelovitoBundle\Exception\NotFoundException
     */
    public function getCategoryById($id)
    {
        return $this->productCatRepo->findOneOrFail(['id' => $id]);
    }

    public function createProduct($name)
    {
        if (empty($name)) {
            throw new \Exception('empty name');
        }

        $this->productsRepo->create($name);
    }

    public function createCategory($name)
    {
        if (empty($name)) {
            throw new \Exception('empty name');
        }

        $this->productCatRepo->create($name);
    }

    public function createProductAttribute($formData)
    {
        $ent = new ProductAttribute();

        $ent
            ->setName($formData[C::FORM_TITLE])
            ->setComment($formData[C::FORM_COMMENT])
            ->setActive(true)
            ->setType($formData[C::FORM_ATTRIBUTE_TYPE]);

        $this->em->persist($ent);
        $this->em->flush($ent);
    }

    public function updateCategory($id, $formData)
    {
        $ent = $this->getCategoryById($id);

        $ent
            ->setName($formData[C::FORM_TITLE])
            ->setActive($formData[C::FORM_IS_ACTIVE]);

        $this->em->flush($ent);

        return $ent;
    }

    public function updateProduct($id, $formData)
    {
        $ent = $this->getProductById($id);

        $cat = $this->em->getReference(C::REPO_PRODUCT_CATEGORY, $formData[C::FORM_CATEGORY]);

        $ent
            ->setName($formData[C::FORM_TITLE])
            ->setCategory($cat)
            ->setActive($formData[C::FORM_IS_ACTIVE]);

        $this->em->flush($ent);

        return $ent;
    }

    public function getCategoriesWithProductsForForm()
    {
        return $this->productCatRepo->getProductsWithCategories();
    }

    public function getCategoriesForForm()
    {
        return $this->productCatRepo->getActiveCategoriesList();
    }
}
