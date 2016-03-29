<?php

namespace VelovitoBundle\Repository;

use VelovitoBundle\Entity\CatalogCategory;
use VelovitoBundle\C;

class CatalogCategoryRepository extends GeneralRepository
{
    public function load(array $records, $truncate = false)
    {
        $catItemRepo = $this->_em->getRepository(C::REPO_CATALOG_ITEM);
        $this->_em->beginTransaction();

        try {
            foreach ($records as $catContent) {
                $categoryEnt = $this->getNewEntity($catContent);
                $this->_em->persist($categoryEnt);

                foreach ($catContent['children'] as $itemContent) {
                    $itemContent['category'] = $categoryEnt;
                    $itemEnt = $catItemRepo->getNewEntity($itemContent);
                    $this->_em->persist($itemEnt);
                }
            }

            if ($truncate) {
                $this->truncateTable();
            }

            $this->_em->flush();
            $this->_em->getConnection()->commit();
        } catch (\Exception $e) {
            $this->_em->rollback();
            throw $e;
        }

    }

//    public function create(array $data)
//    {
//        $ent = $this->getNewEntity($data);
//
//        $this->_em->persist($ent);
//        $this->_em->flush($ent);
//    }
//
//    public function getEntity(array $data)
//    {
//        if (!$ent = $this->find($data['id'])) {
//            return $this->getNewEntity($data);
//        }
//
//        return $ent;
//    }
//
//    public function getNewEntity(array $data)
//    {
//        $ent = new CatalogCategory();
//        $ent
//            ->setId($data['id'])
//            ->setName($data['name'])
//            ->setAlias($data['alias']);
//
//        return $ent;
//    }
}
