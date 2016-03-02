<?php

namespace AppBundle\Controller;

use AppBundle\Form\Security\RegisterForm;
use AppBundle\C;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        if ($request->attributes->has(Security::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(Security::AUTHENTICATION_ERROR);
        } else {
            $error = $request->getSession()->get(Security::AUTHENTICATION_ERROR);
        }

        return $this->render(
            'security/login.html.twig',
            [
                'last_username' => $request->getSession()->get(Security::LAST_USERNAME),
                'error'         => $error,
            ]
        );
    }

    /**
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request)
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
            } else {
                $this->addFlash('warning', 'Форма заполнена неверно');
            }
        }

        return $this->render(
            'security/register.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction(Request $request)
    {
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction(Request $request)
    {
    }
}
