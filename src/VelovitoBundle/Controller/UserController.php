<?php

namespace VelovitoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use VelovitoBundle\C;
use VelovitoBundle\Form\Ad\NewAdForm;
use VelovitoBundle\Form\User\UserProfileForm;

class UserController extends GeneralController
{
    public function newAdAction(Request $request)
    {
        $this->denyUnlessAuthenticatedFully();
        $form = $this->createForm(NewAdForm::class);

        if ($request->isMethod('POST')) {
            $formData = $form->handleRequest($request)->getData();
            $this->get(C::MODEL_ADVERTISEMENT)->createNewAd($formData, $this->getUser());
        }

        return $this->render(
            'VelovitoBundle:user:new_ad.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    public function profileAction(Request $request)
    {
        $this->denyUnlessAuthenticatedFully();

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

    public function myAdsAction(Request $request)
    {
        $this->denyUnlessAuthenticatedFully();

        return $this->render(
            'VelovitoBundle:user:my_ads.html.twig',
            [
                'userAds' => $this->get(C::MODEL_ADVERTISEMENT)->getAdsByUserId($this->getUser()->getId()),
            ]
        );
    }

    public function favoritesAction(Request $request)
    {
        $this->denyUnlessAuthenticatedFully();

        return $this->render(
            'VelovitoBundle:user:favorited_ads.html.twig',
            [
                'favoritesAds' => $this->get(C::MODEL_ADVERTISEMENT)->getFavoritedAdsByUserId(
                    $this->getUser()->getId()
                ),
            ]
        );
    }
}