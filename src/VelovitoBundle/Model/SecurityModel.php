<?php

namespace VelovitoBundle\Model;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use VelovitoBundle\C;
use Doctrine\ORM\EntityManager;
use VelovitoBundle\Entity\User;
use VelovitoBundle\Model\User\UserModel;
use VelovitoBundle\Model\VkApi\VkApiModel;
use VelovitoBundle\Service\CommonFunction;

class SecurityModel
{
    private $em;
    private $session;
    private $tokenStorage;
    private $vkApi;

    private $userRepo;

    public function __construct(
        EntityManager $em,
        Session $session,
        TokenStorage $tokenStorage,
        VkApiModel $vkApi,
        UserModel $userModel
    )
    {
        $this->em = $em;
        $this->session = $session;
        $this->tokenStorage = $tokenStorage;
        $this->vkApi = $vkApi;
        $this->userModel = $userModel;

        $this->userRepo = $em->getRepository(C::REPO_USER);
    }

    public function createUser($username, $password, $email = null)
    {
        $params = [
            'username' => $username,
            'email'    => $email,
            'password' => $password,
            'role'     => $this->em->getRepository(C::REPO_ROLE)->findOneOrFail(C::ROLE_USER),
        ];

        return $this->em->getRepository('VelovitoBundle:User')->create($params);
    }

    public function authenticateByVk()
    {
        try {
            $vkToken = $this->session->get(C::PARAM_VK_TOKEN);
            $vkUserId = $this->session->get(C::PARAM_VK_USER_ID);
        } catch (\Exception $e) {
            throw new \Exception('vk session params not found');
        }


        if ($user = $this->userModel->getUserByVkAccountId($vkUserId)) {
            $this->forceAuthenticate($user);

            return true;
        };

        $userInfo = $this->vkApi->getUserInfo();

        $user = $this->createUser(
            $userInfo['screen_name'],
            CommonFunction::generatePassword(12),
            $userInfo['screen_name']
        );

        $user->setVkAccountId($vkUserId);
        $this->em->flush();
        $this->forceAuthenticate($user);

        return true;
    }

    public function forceAuthenticate(User $user)
    {
        $token = new UsernamePasswordToken($user, $user->getPassword(), "secured_area", $user->getRoles());
        $this->tokenStorage->setToken($token);

        return true;
    }

    public function addVkAccountToUser(User $user)
    {
        $userInfo = $this->vkApi->getUserInfo();

        $user->setVkAccountId($this->session->get(C::PARAM_VK_USER_ID));
        $this->em->flush($user);

        return true;
    }

    public function getUser()
    {
        return $this->tokenStorage->getToken()->getUser();
    }

    public function getToken()
    {
        return $this->tokenStorage->getToken();
    }
}
