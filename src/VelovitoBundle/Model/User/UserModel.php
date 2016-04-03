<?php

namespace VelovitoBundle\Model\User;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use VelovitoBundle\C;
use VelovitoBundle\Model\VkApi\VkApiModel;

class UserModel
{
    private $em;

    public function __construct(EntityManager $em, Session $session, TokenStorage $tokenStorage, VkApiModel $vkApi)
    {
        $this->em = $em;
        $this->session = $session;
        $this->tokenStorage = $tokenStorage;
        $this->vkApi = $vkApi;

        $this->userRepo = $em->getRepository(C::REPO_USER);
    }

    public function getUserByVkAccountId($id)
    {
        return $this->userRepo->findOneBy(
            [
                'vkAccountId' => $id,
            ]
        );
    }

    public function createUserByVkAuth()
    {

    }
}
