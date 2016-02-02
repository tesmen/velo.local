<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Role;

class RoleRepository extends GeneralRepository
{
    public function create($name)
    {
        $this->_em->beginTransaction();
        try {
            $role = new Role();
            $role->setName($name);

            $this->_em->persist($role);

            $this->_em->flush();
            $this->_em->commit();
        } catch (\Exception $e) {
            $this->_em->rollback();
            throw $e;
        }

        return $role;
    }
}
