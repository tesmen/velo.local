<?php

namespace VelovitoBundle\Model;

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
        $this->productsRepo->findAll();
    }

}
