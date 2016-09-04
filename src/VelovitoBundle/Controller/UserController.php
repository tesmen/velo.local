<?php

namespace VelovitoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use VelovitoBundle\C;
use VelovitoBundle\Form\User\UserProfileForm;

class UserController extends GeneralController
{
    public function settingsAction(Request $request)
    {
        $this->denyUnlessAuthenticatedFully();
        $userInfo = $this->get(C::MODEL_VK_API)->getUserInfo();

        $form = $this->createForm(UserProfileForm::class, $this->getUser());

        if ($request->attributes->has(Security::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(Security::AUTHENTICATION_ERROR);
        } else {
            $error = $request->getSession()->get(Security::AUTHENTICATION_ERROR);
        }

        return $this->render(
            'VelovitoBundle:user:settings.html.twig',
            [
                'form'                => $form->createView(),
                C::PARAM_VK_AUTH_LINK => $this->get(C::MODEL_VK_API)->getAuthLink(),
                'user'                => $this->getUser(),
                'vk_info'             => $userInfo,
            ]
        );
    }
    public function viewUserProfileAction(Request $request, $id)
    {
        $this->denyUnlessAuthenticatedFully();

        try {
            $user = $this->get(C::MODEL_SECURITY)->getUserById($id);
        } catch (\Exception $e) {
            $this->addFlash(C::FLASH_ERROR, $e->getMessage());
            return $this->redirectToRoute(C::ROUTE_HOMEPAGE);
        }

        return $this->render(
            'VelovitoBundle:user:view_user_profile.html.twig',
            [
                C::PARAM_VK_AUTH_LINK => $this->get(C::MODEL_VK_API)->getAuthLink(),
                'user'                => $user,
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

    public function favoriteAdvertsAction(Request $request)
    {
        $this->denyUnlessAuthenticatedFully();

        return $this->render(
            'VelovitoBundle:user:favorited_ads.html.twig',
            [
                'favoritesAds' => $this->get(C::MODEL_ADVERTISEMENT)->getFavoriteAdsByUserId(
                    $this->getUser()->getId()
                ),
            ]
        );
    }
}