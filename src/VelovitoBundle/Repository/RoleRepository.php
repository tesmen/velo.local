<?php

namespace VelovitoBundle\Repository;

use VelovitoBundle\Entity\Role;

class RoleRepository extends GeneralRepository
{
    public function load(array $names)
    {
        foreach ($names as $roleName) {
            $this->create($roleName);
        }
    }

    public function create($name)
    {
        if ($existent = $this->findByName($name)) {
            return $existent;
        }

        $role = new Role();
        $role->setName($name);
        $this->_em->persist($role);
        $this->_em->flush();

        return $role;
    }
}
