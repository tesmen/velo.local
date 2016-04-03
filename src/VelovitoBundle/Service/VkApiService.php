<?php
namespace VelovitoBundle\Service;

use Symfony\Bundle\FrameworkBundle\Routing\Router;

class VkApiService
{
    private $authUrl = 'https://oauth.vk.com/authorize';
    private $tokenUrl = 'https://oauth.vk.com/access_token';
    private $version = '5.50';
    private $clientId;
    private $clientSecret;

    public function __construct($clientId, $clientSecret, Router $router)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->redirectUri = $router->generate('vk_auth_token');
    }

    public function getAuthLink()
    {
        $authParams = [
            'client_id'     => $this->clientId,
            'redirect_uri'  => $this->redirectUri,
            'response_type' => 'code',
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

        return json_encode(file_get_contents($tokenLink), true);
    }
}
