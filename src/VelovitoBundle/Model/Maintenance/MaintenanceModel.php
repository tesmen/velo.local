<?php

namespace VelovitoBundle\Model\Maintenance;

use VelovitoBundle\C;
use Doctrine\ORM\EntityManager;
use VelovitoBundle\Entity\CatalogCategory;
use VelovitoBundle\Model\DefaultModel;

class MaintenanceModel
{
    private $em;
    private $defaultModel;

    public function  __construct(EntityManager $em, DefaultModel $defaultModel)
    {
        $this->em = $em;
        $this->defaultModel = $defaultModel;

        $this->productCatRepo = $em->getRepository(C::REPO_PRODUCT_CATEGORY);
        $this->productsRepo = $em->getRepository(C::REPO_PRODUCT);
    }

    function loadRoles()
    {
        $roles = [
            C::ROLE_USER      => 'ROLE_USER',
            C::ROLE_MODERATOR => 'ROLE_MODERATOR',
            C::ROLE_ADMIN     => 'ROLE_ADMIN',
        ];

        $this->em->getRepository(C::REPO_ROLE)->load($roles);
    }

    function loadCategories()
    {
        $category = $this->productCatRepo->create('Велосипеды');

        $this->productsRepo->create([
            C::FORM_TITLE=> 'Горные',
            C::FORM_CATEGORY=> $category->getId(),

        ]);
    }
}
