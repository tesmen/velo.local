<?php

namespace VelovitoBundle\Repository;

use Doctrine\ORM\EntityRepository;


class GeneralRepository extends EntityRepository
{
    public function updateEntity($entity, array $data)
    {
        $entFields = $this->_em->getClassMetadata($this->_entityName)->getFieldNames();

        foreach ($data as $field => $value) {
            if (!in_array($field, $entFields)) {
                continue;
            }

            $setMethod = 'set'.$field;
            $entity->$setMethod($value);
        }

        $this->_em->flush();
    }

    public function update($data)
    {
        $entFields = $this->_em->getClassMetadata($this->_entityName)->getFieldNames();

        $ent = $this->findOneOrFail(
            ['id' => $data['id']]
        );

        unset($data['id']);

        foreach ($data as $field => $value) {
            if (!in_array($field, $entFields)) {
                continue;
            }

            $setMethod = 'set'.$field;
            $ent->$setMethod($value);
        }

        $this->_em->flush();
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
        $ent = $this->findOneBy($fields, $order);
        if (!$ent) {
            throw new NotFoundException($this->_entityName.' not found');
        }

        return $ent;
    }

    public function findByOrFail($fields, $order = null)
    {
        $ents = $this->findBy($fields, $order);
        if (!$ents) {
            throw new NotFoundException($this->_entityName.' not found');
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
