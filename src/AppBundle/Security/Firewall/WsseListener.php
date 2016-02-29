<?php

namespace AppBundle\Security\Firewall;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Artvisio\DockerBillingBundle\Security\Authentication\Token\WsseToken;

class WsseListener implements ListenerInterface
{

    protected $securityContext;
    protected $authenticationManager;
    protected $session;

    public function __construct(
        TokenStorage $securityContext,
        AuthenticationManagerInterface $authenticationManager,
        Session $session
    ) {
        $this->securityContext = $securityContext;
        $this->authenticationManager = $authenticationManager;
        $this->session = $session;
    }

    public function handle(GetResponseEvent $event)
    {
        $token = new WsseToken();
        $token->setToken($this->session->get('token'));
        $token->setId($this->session->get('id'));
        $token->setCreated(new \DateTime());

        try {
            $authToken = $this->authenticationManager->authenticate($token);
            $this->securityContext->setToken($authToken);

            return;
        } catch (AuthenticationException $failed) {
            $this->securityContext->setToken(null);
            $this->session->invalidate();

            return;
        }
    }
} 