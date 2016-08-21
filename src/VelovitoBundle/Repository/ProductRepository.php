<?php

namespace VelovitoBundle\Repository;

use VelovitoBundle\C;
use VelovitoBundle\Entity\Product;

class ProductRepository extends GeneralRepository
{
    public function create(array $data)
    {
        $ent = new Product();
        $cat = $this->_em->getReference(C::REPO_PRODUCT_CATEGORY, $data[C::FORM_CATEGORY]);
        $ent
            ->setActive(true)
            ->setCategory($cat)
            ->setName($data[C::FORM_TITLE]);

        $this->_em->persist($ent);
        $this->_em->flush($ent);
    }
}
