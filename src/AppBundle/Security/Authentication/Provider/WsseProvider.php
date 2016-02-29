<?php

namespace AppBundle\Security\Authentication\Provider;

use Artvisio\DockerBillingBundle\Model\TokenModel;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Artvisio\DockerBillingBundle\Security\Authentication\Token\WsseToken;
use Artvisio\DockerBillingBundle\C;
use Artvisio\BillmanagerBundle\Model\Customer;

class WsseProvider implements AuthenticationProviderInterface
{

    private $userProvider;
    protected $tokenModel;
    protected $session;
    protected $userModel;

    public function __construct(
        UserProviderInterface $userProvider,
        TokenModel $tokenModel,
        Session $session
    ) {
        $this->userProvider = $userProvider;
        $this->tokenModel = $tokenModel;
        $this->session = $session;
    }

    /* ~0.30 sec */
    public function authenticate(TokenInterface $token)
    {
        switch ($role = $this->session->get('role')) {
            case C::ROLE_ADMIN:
            case C::ROLE_ALLOWED_TO_SWITCH:
                try {
                    $checks = [
                        C::ROLE_ADMIN             => 'account',
                        C::ROLE_ALLOWED_TO_SWITCH => 'user',
                    ];

                    $token = $this->tokenModel->createTokenFromSession();
                    $admin = new Customer($token);
                    $admin->make($checks[$role], []); //check billing token alive

                    $roles[] = $role;
                    $authenticatedToken = new WsseToken($roles);
                    $authenticatedToken->setUser($this->session->get('username'));
                } catch (\Exception $e) {
                    throw new AuthenticationException('The WSSE authentication failed.');
                }
                break;

            case C::ROLE_USER:
                try {
                    $token = $this->tokenModel->createTokenFromSession();
                    $customer = new Customer($token);
                    $customer->getUsername(); //check billing token alive

                    $roles[] = $role;
                    $authenticatedToken = new WsseToken($roles);
                    $authenticatedToken->setUser($this->session->get('username'));
                    $authenticatedToken->setId($this->session->get('id'));
                } catch (\Exception $e) {
                    throw new AuthenticationException('The WSSE authentication failed.');
                }
                break;

            default:
                throw new AuthenticationException('The WSSE role not found.');
        }

        return $authenticatedToken;
    }

    public function supports(TokenInterface $token)
    {
        return $token instanceof WsseToken;
    }
} 