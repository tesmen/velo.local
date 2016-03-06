<?php

namespace VelovitoBundle\Repository;

use VelovitoBundle\Entity\CatalogCategory;

class CatalogCategoryRepository extends GeneralRepository
{
    public function load(array $data)
    {
        $this->_em->beginTransaction();

        try {
            foreach ($data as $categoryData) {
                $ent = new CatalogCategory();
                $ent->setId($categoryData['id']);
                $ent->setName($categoryData['name']);
                $ent->setAlias($categoryData['alias']);

                $this->_em->persist($ent);
            }

            $this->truncateTable();
            $this->_em->flush();
            $this->_em->commit();
        } catch (\Exception $e) {
            $this->_em->rollback();
            throw $e;
        }
    }

    public function create($data)
    {


        return $ent;
    }
}
