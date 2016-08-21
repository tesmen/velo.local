<?php

namespace VelovitoBundle\Repository;

use VelovitoBundle\C;
use VelovitoBundle\Entity\ProductCategory;

class ProductCategoryRepository extends GeneralRepository
{
    public function getActiveCategories()
    {
        $q = $this->createQueryBuilder('q')
            ->where('q.active = :active')
            ->getQuery();
        $q->setParameter('active', true);

        return $q->getArrayResult();
    }

    public function create($name)
    {
        $ent = new ProductCategory();

        $ent
            ->setActive(true)
            ->setName($name);

        $this->_em->persist($ent);
        $this->_em->flush($ent);

        return $ent;
    }

    public function getActiveCategoriesList($flip = false)
    {
        $result = [];

        foreach ($this->getActiveCategories() as $row) {
            $result[$row['name']] = $row['id'];
        }

        return $flip
            ? array_flip($result)
            : $result;
    }

    public function getProductsWithCategories()
    {
        $q = $this->_em->getConnection()->prepare(
            'SELECT p.id, p.name, pc.name as category_name
FROM `products` p
JOIN `product_categories` pc
on p.category_id = pc.id
where p.active = 1'
        );

        $q->execute();

        return $q->fetchAll();
    }

    public function getActiveCatsWithProductsForMenu()
    {
        $result = [];
        $q = $this->_em->getConnection()->prepare(
            'SELECT p.id, p.name, pc.id as category_id, pc.name as category_name
                FROM `products` p
                JOIN `product_categories` pc
                on p.category_id = pc.id
                where p.active = 1'
        );

        $q->execute();


        foreach ($q->fetchAll() as $row) {
            $categoryId = $row['category_id'];

            if (!isset($result[$categoryId])) {
                $result[$categoryId] = [
                    'name'     => $row['category_name'],
                    'products' => [],
                ];
            }

            $result[$categoryId]['products'][$row['id']] = $row['name'];
        }

        return $result;
    }
}
