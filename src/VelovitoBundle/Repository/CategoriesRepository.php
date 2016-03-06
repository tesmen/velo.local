<?php

namespace VelovitoBundle\Repository;

use VelovitoBundle\Entity\Categories;

class CategoriesRepository extends GeneralRepository
{
    public function load(array $data)
    {
        $this->truncateTable();

        foreach ($data as $CategoriesItemData) {
            $this->create($CategoriesItemData);
        }
    }

    public function create($data)
    {
        $this->_em->beginTransaction();

        try {
            $ent = new Categories();
            $ent->setId($data['id']);
            $ent->setName($data['name']);
            $ent->setAlias($data['alias']);

            $this->_em->persist($ent);

            $this->_em->flush();
            $this->_em->commit();
        } catch (\Exception $e) {
            $this->_em->rollback();
            throw $e;
        }

        return $ent;
    }
}
