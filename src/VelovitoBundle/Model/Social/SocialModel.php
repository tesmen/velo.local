<?php

namespace VelovitoBundle\Model\Social;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;

class SocialModel
{
    public function __construct(EntityManager $em, Session $session)
    {
        $this->em = $em;
        $this->session = $session;
    }

    public function getTenNews()
    {
        $qb = $this->em->getRepository('VelovitoBundle:User')->createQueryBuilder('user');

        $qb->addOrderBy('user.registeredDate', 'ASC');
        var_dump($qb->getQuery()->getArrayResult());die;
        return $qb->getQuery()->getArrayResult();
    }
}
