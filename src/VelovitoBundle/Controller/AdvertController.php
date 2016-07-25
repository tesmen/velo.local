<?php

namespace VelovitoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use VelovitoBundle\C;
use VelovitoBundle\Form\Admin\EditProductForm;
use VelovitoBundle\Form\Advert\EditAdvertForm;
use VelovitoBundle\Form\Advert\NewAdvertForm;
use VelovitoBundle\Form\Advert\UnpublishAdvertForm;
use VelovitoBundle\Form\Ajax\UploadPhotoForm;

class AdvertController extends GeneralController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @deprecated
     * @see \VelovitoBundle\Controller\AdvertController::addAdvertAction
     */
    public function newAdvertAction(Request $request)
    {
        $this->denyUnlessAuthenticatedFully();
        $adModel = $this->get(C::MODEL_ADVERTISEMENT);

        $formOptions = [
            'categories' => $this->get(C::MODEL_ADVERTISEMENT)->getProductListWithCategoriesForForm(),
        ];

        $form = $this->createForm(NewAdvertForm::class, $formOptions);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $formData = $form->getData();
                $formData[C::FORM_PHOTO_FILENAMES] = $request->get(C::FORM_PHOTO_FILENAMES);
                $adModel->createNewAdvert($formData, $this->getUser());
                $this->addFlash('success', 'Объявление добавлено');
            }

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

    public function addAdvertAction(Request $request)
    {
        $this->denyUnlessAuthenticatedFully();
        $adModel = $this->get(C::MODEL_ADVERTISEMENT);
        $options[C::FORM_PRODUCT_LIST] = $adModel->getProductListWithCategoriesForForm();

        $form = $this->createForm(NewAdvertForm::class, $options);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $formData = $form->getData();
                try {
                    $advertId = $adModel->createNewAdvert($formData);
                    $this->addFlash(C::FLASH_SUCCESS, 'Объявление добавлено');

                    return $this->redirectToRoute('my_ads');
                } catch (\Exception $e) {
                    $this->addFlash(C::FLASH_ERROR, $e->getMessage());
                }
            } else {
                $this->addFlash(C::FLASH_ERROR, 'Форма не валидна');
            }

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

    /*
     * todo check user rights to edit
     */
    public function editAdvertAction(Request $request, $advertId)
    {
        $this->denyUnlessAuthenticatedFully();
        $adModel = $this->get(C::MODEL_ADVERTISEMENT);
        $advertEnt = $adModel->getAdvertById($advertId);

        $formOptions = [
            'entity'             => $advertEnt,
            C::FORM_TITLE        => $advertEnt->getTitle(),
            C::FORM_PRICE        => $advertEnt->getPrice(),
            C::FORM_PRODUCT      => $advertEnt->getProduct()->getId(),
            C::FORM_PRODUCT_LIST => $adModel->getProductListWithCategoriesForForm(),
            C::FORM_IS_PUBLISHED => $advertEnt->getIsPublished(),
            C::FORM_DESCRIPTION  => $advertEnt->getDescription(),
        ];

        $form = $this->createForm(NewAdvertForm::class, $formOptions);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $formData = $form->getData();
                $formData[C::FORM_PHOTO_FILENAMES] = $request->get(C::FORM_PHOTO_FILENAMES);

                try {
                    $adModel->createNewAdvert($formData, $advertEnt);
                    $this->addFlash(C::FLASH_SUCCESS, 'Изменения сохранены');

                    return $this->redirectToThis(
                        ['advertId' => $advertId]
                    );
                } catch (\Exception $e) {
                    $this->addFlash(C::FLASH_ERROR, $e->getMessage());
                }

                return $this->redirectToRoute(
                    C::ROUTE_ADVERT_EDIT,
                    ['advertId' => $advertId]
                );
            }
        }

        return $this->render(
            'VelovitoBundle:advert:edit_advert.html.twig',
            [
                'form'       => $form->createView(),
                'advert'     => $advertEnt,
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