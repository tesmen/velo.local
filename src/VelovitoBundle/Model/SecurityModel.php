<?php

namespace VelovitoBundle\Model;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use VelovitoBundle\C;
use Doctrine\ORM\EntityManager;
use VelovitoBundle\Entity\ResetPasswordLink;
use VelovitoBundle\Entity\User;
use VelovitoBundle\Exception\ConsistencyException;
use VelovitoBundle\Exception\NotFoundException;
use VelovitoBundle\Exception\UserNotFoundException;
use VelovitoBundle\Model\Feedback\FeedbackModel;
use VelovitoBundle\Model\User\UserModel;
use VelovitoBundle\Model\VkApi\VkApiModel;
use VelovitoBundle\Model\Traits\RepoTrait;
use VelovitoBundle\Service\CommonFunction;

class SecurityModel
{
    use RepoTrait;

    private $em;
    private $session;
    private $tokenStorage;
    private $vkApi;
    private $userModel;
    private $feedBackModel;

    private $userRepo;

    public function __construct(
        EntityManager $em,
        Session $session,
        TokenStorage $tokenStorage,
        VkApiModel $vkApi,
        UserModel $userModel,
        FeedbackModel $feedbackModel
    )
    {
        $this->em = $em;
        $this->session = $session;
        $this->tokenStorage = $tokenStorage;
        $this->vkApi = $vkApi;
        $this->userModel = $userModel;
        $this->feedBackModel = $feedbackModel;

        $this->userRepo = $em->getRepository(C::REPO_USER);
    }

    public function createUser($username, $password, $email = null)
    {
        $user = $this->getUserByEmail($email);

        if ($user) {
            throw new ConsistencyException('Email already used');
        }

        $params = [
            'username' => $username,
            'email'    => $email,
            'password' => $password,
            'role'     => $this->em->getRepository(C::REPO_ROLE)->findOneOrFail(C::ROLE_USER),
        ];

        return $this->em->getRepository(C::REPO_USER)->create($params);
    }

    /**
     * @param $email
     * @return User | Object | null
     */
    public function getUserByEmail($email)
    {
        return $this->getUserRepo()->findOneBy([
            'email' => $email,
        ]);
    }

    public function setUser($user){
        $this->forceAuthenticate($user);
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

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->tokenStorage->getToken()->getUser();
    }

    /**
     * @param $id
     * @return User
     */
    public function getUserById($id)
    {
        return $this->getUserRepo()->findOneOrFail([
            'id' => $id,
        ]);
    }

    public function getToken()
    {
        return $this->tokenStorage->getToken();
    }

    public function resetUserPassword($email)
    {
        $link = $this->createResetLink($email);
        $this->feedBackModel->sendResetLinkMail($email);
    }

    private function createResetLink($email)
    {
        $user = $this->getUserByEmail($email);

        if (!$user) {
            throw new UserNotFoundException();
        }

        return  $this->getResetLinkRepo()->create($user);
    }
}
