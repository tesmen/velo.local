<?php

namespace VelovitoBundle\Model;

use VelovitoBundle\C;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Exception\ParseException;

class SecurityModel
{
    private $em;

    public function __construct(EntityManager $em, $kernel)
    {
        $this->em = $em;
        $this->kernel = $kernel;
    }

    public function createUser($username, $password, $email)
    {
        $params = [
            'username' => $username,
            'email'    => $email,
            'password' => $password,
            'role' => $this->em->getRepository('VelovitoBundle:Role')->findOneByName('ROLE_USER'),
        ];

        $this->em->getRepository('VelovitoBundle:User')->create($params);

    }
}
