<?php

namespace VelovitoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use VelovitoBundle\C;
use VelovitoBundle\Form\Advert\EditAdvertForm;
use VelovitoBundle\Form\Advert\NewAdvertForm;
use VelovitoBundle\Form\Advert\UnpublishAdvertForm;
use VelovitoBundle\Form\Ajax\UploadPhotoForm;

class AdvertController extends GeneralController
{
    public function newAdvertAction(Request $request)
    {
        $adModel = $this->get(C::MODEL_ADVERTISEMENT);

        $this->denyUnlessAuthenticatedFully();
        $formOptions = [
            'ad_statuses' => $adModel->getAdStatusMap(),
            'categories'  => $this->get(C::MODEL_DEFAULT)->getMenu(),
        ];

        $form = $this->createForm(NewAdvertForm::class, $formOptions);

        if ($request->isMethod('POST')) {
            $formData = $form->handleRequest($request)->getData();
            $formData[C::FORM_PHOTO_FILENAMES] = $request->get(C::FORM_PHOTO_FILENAMES);
            $adModel->createNewAd($formData, $this->getUser());
            $this->addFlash('success', 'Объявление добавлено');

            return $this->redirectToRoute(C::ROUTE_MY_ADS);
        }

        return $this->render(
            'VelovitoBundle:advert:new_advert.html.twig',
            [
                'form'       => $form->createView(),
                'uploadForm' => $this->createForm(UploadPhotoForm::class)->createView(),
            ]
        );
    }

    public function unPublishAdvertAction(Request $request, $advertId)
    {
        $advertEnt = $this->get(C::MODEL_ADVERTISEMENT)->getAdvertById($advertId);
        $form = $this->createForm(UnpublishAdvertForm::class);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            $this->get(C::MODEL_ADVERTISEMENT)->unpublishAdvert($advertId, $form->getClickedButton()->getName());
            $this->addFlash('success', 'Объявление снято с публикации');

            return $this->redirectToRoute(C::ROUTE_MY_ADS);
        }

        return $this->render(
            'VelovitoBundle:advert:unpublish_advert.html.twig',
            [
                'advert' => $advertEnt,
                'form'   => $form->createView(),
            ]
        );
    }

    public function editAdvertAction(Request $request)
    {
        $adModel = $this->get(C::MODEL_ADVERTISEMENT);

        $this->denyUnlessAuthenticatedFully();
        $formOptions = [
            'ad_statuses' => $adModel->getAdStatusMap(),
            'categories'  => $this->get(C::MODEL_DEFAULT)->getMenu(),
        ];

        $form = $this->createForm(NewAdvertForm::class, $formOptions);

        if ($request->isMethod('POST')) {
            $formData = $form->handleRequest($request)->getData();
            $formData[C::FORM_PHOTO_FILENAMES] = $request->get(C::FORM_PHOTO_FILENAMES);
            $adModel->createNewAd($formData, $this->getUser());
            $this->addFlash('success', 'Объявление добавлено');

            return $this->redirectToRoute(C::ROUTE_MY_ADS);
        }

        return $this->render(
            'VelovitoBundle:advert:new_advert.html.twig',
            [
                'form'       => $form->createView(),
                'uploadForm' => $this->createForm(UploadPhotoForm::class)->createView(),
            ]
        );
    }

    public function viewAdvertAction(Request $request, $advertId)
    {
        $adModel = $this->get(C::MODEL_ADVERTISEMENT);

        //$form = $this->createForm(EditAdForm::class, $formOptions);
        $advertEnt = $this->get(C::MODEL_ADVERTISEMENT)->getAdvertById($advertId);
        $this->get(C::MODEL_ADVERTISEMENT)->incrementViewed($advertEnt);

        if ($request->isMethod('POST')) {

        }

        return $this->render(
            'VelovitoBundle:advert:view_advert.html.twig',
            [
                'advert' => $advertEnt,
            ]
        );
    }
}