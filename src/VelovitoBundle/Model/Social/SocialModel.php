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
        $users = $this->em->getRepository(C::REPO_USER)->getLastUsers(5);

        foreach ($users as $user) {
            $result[] = (new NewsRecord())
                ->setCreated($user->getRegisteredDate())
                ->setSubject('Новый пользователь')
                ->setText('Теперь с нами <b>' . $user->getUsername() .'</b>')
                ->setPicture('plus1.png');
        }

        return $result;
    }
}
