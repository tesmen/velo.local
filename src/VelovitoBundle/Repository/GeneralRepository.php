<?php

namespace VelovitoBundle\Repository;

use Doctrine\ORM\EntityRepository;
use VelovitoBundle\Exception\NotFoundException;


class GeneralRepository extends EntityRepository
{
    public function update($entity, array $data)
    {
        $this->_em->beginTransaction();

        try {
            foreach ($data as $fieldName => $value) {
                $setMethod = 'set'.$fieldName;
                $entity->$setMethod($data[$fieldName]);
            }

            $this->_em->flush();
            $this->_em->commit();
        } catch (\Exception $e) {
            $this->_em->rollback();
            throw $e;
        }

        return $entity;
    }

    public function getTableName()
    {
        return $this->_em->getClassMetadata($this->_entityName)->getTableName();
    }

    protected function truncateTable($tableName = null, $cascade = false)
    {
        if (is_null($tableName)) {
            $tableName = $this->getTableName();
        }

        $connection = $this->_em->getConnection();
        $platform = $connection->getDatabasePlatform();
        $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 0;');
        $connection->executeUpdate($platform->getTruncateTableSQL($tableName, $cascade));
        $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 1;');
    }

    public function resetIncrement($tableName)
    {
        $this->_em->getConnection()->exec("ALTER TABLE $tableName AUTO_INCREMENT = 1;");
    }

    public function findOneOrFail($fields, $order = null)
    {
        if (is_array($fields)) {
            if (!$ent = $this->findOneBy($fields)) {
                $search = [];

                foreach ($fields as $k => $v) {
                    $search[] = "$k => $v";
                }

                throw new NotFoundException($this->_entityName.' not found with params '.implode(', ', $search));
            }
        } else {
            // quick findById
            if (!$ent = $this->find($fields)) {
                throw new NotFoundException($this->_entityName.' not found with id '.$fields);
            }
        }

        return $ent;
    }

    public function findByOrFail($fields, $order = null)
    {
        $ents = $this->findBy($fields, $order);
        if (!$ents) {
            $search = [];

            foreach ($fields as $k => $v) {
                $search[] = "$k => $v";
            }

            throw new NotFoundException($this->_entityName.' not found with '.implode(', ', $search));
        }

        return $ents;
    }

    public function addParam($id, $array)
    {
        if (!is_array($array)) {
            return false;
        }

        $orderItemEnt = $this->findOneById($id);

        $initialArray = is_array($orderItemEnt->getSerializedParams())
            ? $orderItemEnt->getSerializedParams()
            : [];

        $orderItemEnt->setSerializedParams(array_merge($initialArray, $array));
        $this->_em->flush();
    }
}
