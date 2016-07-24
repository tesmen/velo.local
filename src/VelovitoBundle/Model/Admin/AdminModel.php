<?php

namespace VelovitoBundle\Model\Admin;

use Doctrine\ORM\EntityManager;
use VelovitoBundle\C;
use VelovitoBundle\Entity\Product;
use VelovitoBundle\Entity\ProductAttribute;

class AdminModel
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;

        $this->productsRepo = $em->getRepository('VelovitoBundle:Product');
        $this->productsAttrRepo = $em->getRepository('VelovitoBundle:ProductAttribute');
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

    public function createProduct($name)
    {
        if (empty($name)) {
            throw new \Exception('empty name');
        }

        $this->productsRepo->create($name);
    }

    public function getCategoriesForForm()
    {
        return $this->productCatRepo->getCategoriesWithProductsForForm();
    }
}
