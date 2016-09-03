<?php

namespace VelovitoBundle\Repository;

use Doctrine\ORM\EntityRepository;
use VelovitoBundle\Exception\NotFoundException;


class GeneralRepository extends EntityRepository
{
    public function isExists($criteria)
    {
        return !empty($this->findOneBy($criteria));
    }

    public function failOnExists($criteria)
    {
        if($this->isExists($criteria)) {
            throw new \Exception(
                sprintf('%s already exists with %s',
                    $this->getClassName(),
                    json_encode($criteria)
            ));
        };
    }

    public function fillEntity($ent, array  $data)
    {

        foreach ($data as $key => $value) {
            $setMethod = 'set'.$key;
            $ent->$setMethod($value);
        }
    }

    public function update($id, array $data)
    {
        $entity = $this->findOneOrFail(
            ['id' => $id,]
        );

        $this->fillEntity($entity, $data);
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

    /**
     * @param integer|array $params
     * @return object
     * @throws \Exception
     */
    public function findOrCreate($params)
    {
        if (is_integer($params)) {
            $criteria = [
                'id' => $params,
            ];
        } elseif (is_array($params)) {
            $criteria = $params;
        } else {
            throw new \Exception('wrong class passed to ' . __FUNCTION__);
        }

        $persistent = $this->findOneBy($criteria);

        if ($persistent) {
            return $persistent;
        }

        return new $this->_entityName;

    }
}
