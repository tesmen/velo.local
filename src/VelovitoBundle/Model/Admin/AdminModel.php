<?php

namespace VelovitoBundle\Model\Admin;

use Doctrine\ORM\EntityManager;

class AdminModel
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;

        $this->productsRepo = $em->getRepository('VelovitoBundle:Product');
    }

    public function getAllProducts()
    {
        return $this->productsRepo->findAll();
    }

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

}
