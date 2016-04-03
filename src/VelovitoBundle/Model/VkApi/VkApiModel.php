<?php
namespace VelovitoBundle\Model\VkApi;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use VelovitoBundle\C;
class VkApiModel
{
    private $authUrl = 'https://oauth.vk.com/authorize';
    private $tokenUrl = 'https://oauth.vk.com/access_token';
    private $version;
    private $clientId;
    private $clientSecret;

    public function __construct(
        $clientId,
        $clientSecret,
        $version,
        Router $router,
        Session $session,
        TokenStorage $tokenStorage
    ) {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->version = $version;
        $this->redirectUri = $router->generate(C::ROUTE_VK_AUTH_TOKEN, [], UrlGeneratorInterface::ABSOLUTE_URL);
        $this->session = $session;
        $this->tokenStorage = $tokenStorage;
    }


    public function getAuthLink()
    {
        $authParams = [
            'client_id'     => $this->clientId,
            'redirect_uri'  => $this->redirectUri,
            'response_type' => 'code',
            'scope'         => 'friends',
            'display'       => 'page',
            'v'             => $this->version,
        ];


        return $this->authUrl.'?'.urldecode(http_build_query($authParams));
    }

    public function getToken($code)
    {
        $tokenParams = [
            'client_id'     => $this->clientId,
            'client_secret' => $this->clientSecret,
            'code'          => $code,
            'v'             => $this->version,
            'redirect_uri'  => $this->redirectUri,
        ];

        $tokenLink = $this->tokenUrl.'?'.urldecode(http_build_query($tokenParams));

        return json_decode(file_get_contents($tokenLink), true);
    }

    public function getUserInfo($currentUser = false)
    {
        $params = [
            'fields'       => 'uid,first_name,last_name,screen_name,sex,bdate,photo_big',
            'access_token' => $this->session->get('vk_token'),
        ];

        if ($currentUser) {
            $params['uids'] = $this->tokenStorage->getToken()->getUser()->getVkAccountId();
        }

        $userInfo = json_decode(
            file_get_contents('https://api.vk.com/method/users.get'.'?'.urldecode(http_build_query($params))),
            true
        )['response'][0];

        return $userInfo;
    }
}