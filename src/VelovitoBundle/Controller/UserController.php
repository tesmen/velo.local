<?php

namespace VelovitoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use VelovitoBundle\C;
use VelovitoBundle\Form\User\UserProfileForm;

class UserController extends Controller
{
    public function profileAction(Request $request)
    {
        $form = $this->createForm(UserProfileForm::class, $this->getUser());

        if ($request->attributes->has(Security::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(Security::AUTHENTICATION_ERROR);
        } else {
            $error = $request->getSession()->get(Security::AUTHENTICATION_ERROR);
        }

        return $this->render(
            'VelovitoBundle:user:profile.html.twig',
            [
                'last_username' => $request->getSession()->get(Security::LAST_USERNAME),
                'error'         => $error,
                'form'          => $form->createView(),
            ]
        );
    }
}