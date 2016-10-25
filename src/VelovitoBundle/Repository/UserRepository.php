<?php

namespace VelovitoBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use VelovitoBundle\C;
use VelovitoBundle\Entity\User;

class UserRepository extends GeneralRepository
{
    public function create($params)
    {
        $this->_em->beginTransaction();

        try {
            $user = new User();
            $user->setUsername($params['username'])
                ->setRoles($params['role'])
                ->setEmail($params['email'])
                ->setFirstName(isset($params['first_name']) ? $params['first_name'] : null)
                ->setPhone(isset($params['phone']) ? $params['phone'] : null)
                ->setRegisteredDate()
                ->setStatus(C::STATUS_USER_ACTIVE);

            $salt = md5(time());
            $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
            $password = $encoder->encodePassword($params['password'], $salt);
            $user->setPassword($password);
            $user->setSalt($salt);

            $this->_em->persist($user);

            $this->_em->flush();
            $this->_em->commit();
        } catch (\Exception $e) {
            $this->_em->rollback();
            throw $e;
        }

        return $user;
    }

    public function findAllExceptSystem()
    {
        return $this->createQueryBuilder('u')
            ->where('u.username != :name')
            ->setParameter('name', C::SYSTEM_USER)
            ->getQuery()->getResult();
    }

    /**
     * @param int $count
     * @param string $order
     * @return User[]
     */
    public function getLastUsers($count = 10, $order = 'DESC')
    {
        $qb = $this->createQueryBuilder('u');
        $qb->addOrderBy('u.registeredDate', $order);
        $qb->setMaxResults($count);

        return $qb->getQuery()->getResult();
    }
}
