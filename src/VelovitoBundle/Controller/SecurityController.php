<?php

namespace VelovitoBundle\Controller;

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
        $secureParams = [
            'client_id' => 5387412,
            'client_secret' => 'm8kU9FlWTEwAMJhqL79E',
            'redirect_uri' => $this->generateUrl('vk_auth_success'),
            'code' => $request->get('code'),
//            'v' => '5.50',
        ];

        $url = 'https://oauth.vk.com/access_token'.'?'.http_build_query($secureParams);
        $info = json_decode(file_get_contents($url));

        var_dump($url);
        var_dump($info);

        exit;
    }

    public function vkAuthSuccessAction(Request $request)
    {
        $params = [
            'count' => 20,
            'order' => 'hints',
            'access_token' => $request->get('code'),
            'offset' => $request->get('code'),
            'v' => '5.50',
        ];
        $url = 'https://oauth.vk.com/access_token'.'?'.http_build_query($params);
        $userInfo = json_decode(file_get_contents($url));

        var_dump($url);
        var_dump($userInfo);

        exit;
    }

    public function registrationAction(Request $request)
    {
        $form = $this->createForm(RegisterForm::class);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $formData = $form->getData();

                $this->get('model.security')->createUser(
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
                'form' => $form->createView(),
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
