<?php

namespace VelovitoBundle\Repository;

use VelovitoBundle\Entity\CatalogCategory;
use VelovitoBundle\C;

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

    public function getActiveCategoriesForForm()
    {
        $result = [];
        $q = $this->_em->getConnection()->prepare(
            'SELECT p.id, p.name, pc.name as category_name
FROM `products` p
JOIN `product_categories` pc
on p.category_id = pc.id
where p.active = 1'
        );

        $q->execute();

        foreach ($q->fetchAll() as $row) {
            $result[$row['category_name']][$row['name']] = $row['id'];
        }

        return $result;
    }

    public function getActiveCategoriesForMenu()
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
