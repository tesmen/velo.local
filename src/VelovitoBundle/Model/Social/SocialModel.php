<?php

namespace VelovitoBundle\Model\Social;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;
use VelovitoBundle\C;

class SocialModel
{
    public function __construct(EntityManager $em, Session $session)
    {
        $this->em = $em;
        $this->session = $session;
    }

    public function getTenNews()
    {
        $result = [];
        $users = $this->em->getRepository(C::REPO_USER)->getLastUsers();

        foreach ($users as $user) {
            $userName = (bool)$user->getFirstName() ? $user->getFirstName() : $user->getUsername();

            $result[] = (new NewsRecord())
                ->setCreated($user->getRegisteredDate())
                ->setSubject('Новый пользователь')
                ->setText('Теперь с нами ' . $userName)
                ->setPicture('plus1.png');
        }

        return $result;
    }
}
