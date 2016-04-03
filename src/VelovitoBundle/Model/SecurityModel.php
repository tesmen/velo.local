<?php

namespace VelovitoBundle\Model;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use VelovitoBundle\C;
use Doctrine\ORM\EntityManager;
use VelovitoBundle\Model\User\UserModel;
use VelovitoBundle\Model\VkApi\VkApiModel;

class SecurityModel
{
    private $em;

    public function __construct(
        EntityManager $em,
        Session $session,
        TokenStorage $tokenStorage,
        VkApiModel $vkApi,
        UserModel $userModel
    ) {
        $this->em = $em;
        $this->session = $session;
        $this->tokenStorage = $tokenStorage;
        $this->vkApi = $vkApi;
        $this->userModel = $userModel;

        $this->userRepo = $em->getRepository(C::REPO_USER);
    }

    public function createUser($username, $password, $email)
    {
        $params = [
            'username' => $username,
            'email'    => $email,
            'password' => $password,
            'role'     => $this->em->getRepository('VelovitoBundle:Role')->findOneByName('ROLE_USER'),
        ];

        $this->em->getRepository('VelovitoBundle:User')->create($params);
    }

    public function authenticateByVk()
    {
        try {
            $vkToken = $this->session->get(C::PARAM_VK_TOKEN);
            $vkUserId = $this->session->get(C::PARAM_VK_USER_ID);
        } catch (\Exception $e) {
            throw new \Exception('vk session params not found');
        }

//        $userInfo = $this->vkApi->getUserInfo();
//        var_dump($userInfo);
//        exit;
        if ($user = $this->userModel->getUserByVkAccountId($vkUserId)) {
            $token = new UsernamePasswordToken($user, $user->getPassword(), "secured_area", $user->getRoles());
            $this->tokenStorage->setToken($token);
        };
    }
}
