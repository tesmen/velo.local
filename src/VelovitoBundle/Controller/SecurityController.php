<?php

namespace VelovitoBundle\Controller;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use VelovitoBundle\Form\Security\RegisterForm;
use VelovitoBundle\C;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class SecurityController extends GeneralController
{
    public function loginAction(Request $request)
    {
        if ($request->attributes->has(Security::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(Security::AUTHENTICATION_ERROR);
        } else {
            $error = $request->getSession()->get(Security::AUTHENTICATION_ERROR);
        }

        return $this->render(
            'VelovitoBundle:security:login.html.twig',
            [
                'last_username' => $request->getSession()->get(Security::LAST_USERNAME),
                'error'         => $error,
            ]
        );
    }

    public function vkAuthTokenAction(Request $request)
    {
        $params = [
            'client_id'     => 5387412,
            'client_secret' => 'm8kU9FlWTEwAMJhqL79E',
            'redirect_uri'  => $this->generateUrl('vk_auth_token', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'code'          => $request->get('code'),
            'v'             => '5.50',
        ];

        $url = 'https://oauth.vk.com/access_token?'.urldecode(http_build_query($params));
        $info = json_decode(file_get_contents($url), true);
        $this->get('session')->set('vk_token', $info['access_token']);

        return $this->redirectToRoute('vk_auth_success');
    }

    public function vkAuthSuccessAction(Request $request)
    {
        var_dump($this->get('session')->get('vk_token'));
        exit;
    }

    public function registrationAction(Request $request)
    {
        $form = $this->createForm(RegisterForm::class);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $formData = $form->getData();

                $this->get(C::MODEL_SECURITY)->createUser(
                    $formData[C::FORM_USERNAME],
                    $formData[C::FORM_PASSWORD],
                    $formData[C::FORM_EMAIL]
                );

                $this->addFlash('success', 'Регистрация пройдена, теперь вы можете войти указав свои данные');

                return $this->redirectToRoute(C::ROUTE_LOGIN);
            } else {
                $this->addFlash('warning', 'Форма заполнена неверно');
            }
        }

        return $this->render(
            'VelovitoBundle:security:registration.html.twig',
            [
                'form'         => $form->createView(),
                'vk_auth_link' => $this->get('service.vk_api')->getAuthLink(),
            ]
        );
    }


    public function loginCheckAction(Request $request)
    {
    }


    public function logoutAction(Request $request)
    {
    }
}
