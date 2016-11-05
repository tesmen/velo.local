<?php

namespace VelovitoBundle\Controller;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
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
                C::PARAM_VK_AUTH_LINK => $this->get(C::MODEL_VK_API)->getAuthLink(),
            ]
        );
    }

    public function vkAuthTokenAction(Request $request)
    {
        if (empty($code = $request->get('code'))) {
            throw new \Exception('empty code');
        }

        $userInfo = $this->get(C::MODEL_VK_API)->getToken($code);
        $this->get('session')->set(C::PARAM_VK_TOKEN, $userInfo['access_token']);
        $this->get('session')->set(C::PARAM_VK_USER_ID, $userInfo['user_id']);

        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $this->get(C::MODEL_SECURITY)->addVkAccountToUser($this->getUser());

            return $this->redirectToRoute(C::ROUTE_SETTINGS);
        }

        return $this->redirectToRoute(C::ROUTE_VK_AUTH_SUCCESS);
    }

    public function vkAuthSuccessAction(Request $request)
    {
        $this->get(C::MODEL_SECURITY)->authenticateByVk();

        return $this->redirectToRoute(C::ROUTE_HOMEPAGE);
    }

    public function registrationAction(Request $request)
    {
        $form = $this->createForm(RegisterForm::class);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                try{
                $formData = $form->getData();

                $this->get(C::MODEL_SECURITY)->createUser(
                    $formData[C::FORM_USERNAME],
                    $formData[C::FORM_PASSWORD],
                    $formData[C::FORM_EMAIL]
                );

                $this->addFlash(C::FLASH_SUCCESS, 'Регистрация пройдена, теперь вы можете войти указав свои данные');

                return $this->redirectToRoute(C::ROUTE_LOGIN);
                } catch(\Exception $e){
                    $this->addFlash(C::FLASH_ERROR, 'Произошла ошибка');

                    return $this->redirectToThis();
                }
            } else {
                $this->addFlash('warning', 'Форма заполнена неверно');
            }
        }

        return $this->render(
            'VelovitoBundle:security:registration.html.twig',
            [
                'form'                => $form->createView(),
                C::PARAM_VK_AUTH_LINK => $this->get(C::MODEL_VK_API)->getAuthLink(),
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
