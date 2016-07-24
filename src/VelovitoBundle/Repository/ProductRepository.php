<?php

namespace VelovitoBundle\Repository;

use VelovitoBundle\C;
use VelovitoBundle\Entity\Product;

class ProductRepository extends GeneralRepository
{
    public function create($name)
    {
        $ent = new Product();
        $cat = $this->_em->getReference(C::REPO_PRODUCT_CATEGORY, $name[C::FORM_CATEGORY]);
        $ent
            ->setActive(true)
            ->setCategory($cat)
            ->setName($name[C::FORM_TITLE]);

        $this->_em->persist($ent);
        $this->_em->flush($ent);
    }
}
