<?php

namespace VelovitoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use VelovitoBundle\C;
use VelovitoBundle\Form\Advert\FillAdvertForm;
use VelovitoBundle\Form\Advert\NewAdvertForm;
use VelovitoBundle\Form\Advert\UnpublishAdvertForm;
use VelovitoBundle\Form\Ajax\UploadPhotoForm;
use VelovitoBundle\Model\Advertisement\AdvertisementModel;

class AdvertController extends GeneralController
{
    public function addAdvertAction(Request $request)
    {
        $this->denyUnlessAuthenticatedFully();
        $adModel = $this->getModel();
        $options[C::FORM_PRODUCT_LIST] = $adModel->getProductListWithCategoriesForForm();

        $form = $this->createForm(NewAdvertForm::class, $options);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $formData = $form->getData();

                try {
                    $advertId = $adModel->createNewAdvert($formData);
                    $this->addFlash(C::FLASH_SUCCESS, 'Объявление добавлено');

                    return $this->redirectToRoute('advert_fill', [
                        'id' => $advertId,
                    ]);
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


    public function fillAdvertAction(Request $request, $id)
    {
        $adModel = $this->getModel();
        $advert = $adModel->getAdvertById($id);
        $this->canUserEditAdvert($advert);
        $form = $this->createAdvertDetailsForm($advert);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            $formData = $form->getData();

            try {
                $adModel->createAdvertAttributeMap($advert, $formData);
                $this->addFlash(C::FLASH_SUCCESS, 'Объявление обновлено!');

                return $this->redirectToRoute(C::ROUTE_MY_ADS);
            } catch (\Exception $e) {
                $this->addFlash(C::FLASH_ERROR, $e->getMessage());
            }

            return $this->redirectToRoute(C::ROUTE_MY_ADS);
        }

        return $this->render(
            'VelovitoBundle:advert:fill_advert.html.twig', [
                'form' => $form->createView(),
                'advert'     => $advert,
                'uploadForm' => $this->createForm(UploadPhotoForm::class)->createView(),
            ]
        );
    }


    public function unPublishAdvertAction(Request $request, $advertId)
    {
        $advertEnt = $this->getModel()->getAdvertById($advertId);
        $form = $this->createForm(UnpublishAdvertForm::class);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            $this->getModel()->unpublishAdvert($advertId, $form->getClickedButton()->getName());
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


    public function editAdvertMainAction(Request $request, $advertId)
    {
        $this->denyUnlessAuthenticatedFully();
        $adModel = $this->getModel();
        $advertEnt = $adModel->getAdvertById($advertId);

        if (!$adModel->userCanEditAdvert($advertEnt)) {
            $this->addFlash(C::FLASH_ERROR, 'Что-то пошло не так...');

            return $this->redirectToRoute(C::ROUTE_MY_ADS);
        }

        $formOptions = [
            'entity'             => $advertEnt,
            C::FORM_TITLE        => $advertEnt->getTitle(),
            C::FORM_PRICE        => $advertEnt->getPrice(),
            C::FORM_PRODUCT      => $advertEnt->getProduct()->getId(),
            C::FORM_PRODUCT_LIST => $adModel->getProductListWithCategoriesForForm(),
            C::FORM_IS_PUBLISHED => $advertEnt->getIsPublished(),
            C::FORM_DESCRIPTION  => $advertEnt->getDescription(),
        ];

        $mainForm = $this->createForm(NewAdvertForm::class, $formOptions);
        $options[C::FORM_ATTRIBUTE_LIST] = $adModel->getAttributesByProductId($advertEnt->getProduct()->getId());
        $detailsForm = $this->createForm(FillAdvertForm::class, $options);

        if ($request->isMethod('POST')) {
            $mainForm->handleRequest($request);

            if ($mainForm->isValid()) {
                $formData = $mainForm->getData();
                $formData[C::FORM_PHOTO_FILENAMES] = $request->get(C::FORM_PHOTO_FILENAMES);

                try {
                    $adModel->createNewAdvert($formData, $advertEnt);
                    $this->addFlash(C::FLASH_SUCCESS, 'Изменения сохранены');
                } catch (\Exception $e) {
                    $this->addFlash(C::FLASH_ERROR, $e->getMessage());
                }

                return $this->redirectToThis(
                    ['advertId' => $advertId]
                );
            }
        }

        return $this->render(
            'VelovitoBundle:advert:edit_advert_main.html.twig',
            [
                'mainForm'       => $mainForm->createView(),
                'detailsForm'       => $detailsForm->createView(),
                'advert'     => $advertEnt,
                'uploadForm' => $this->createForm(UploadPhotoForm::class)->createView(),
            ]
        );
    }


    public function editAdvertDetailsAction(Request $request, $advertId)
    {
        $adModel = $this->getModel();
        $advert = $adModel->getAdvertById($advertId);
        $this->canUserEditAdvert($advert);
        $form = $this->createAdvertDetailsForm($advert, true);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            $formData = $form->getData();

            try {
                $adModel->createAdvertAttributeMap($advert, $formData);
                $this->addFlash(C::FLASH_SUCCESS, 'Объявление обновлено!');
            } catch (\Exception $e) {
                $this->addFlash(C::FLASH_ERROR, $e->getMessage());
            }

            return $this->redirectToThis(
                ['advertId' => $advertId]
            );
        }

        return $this->render(
            'VelovitoBundle:advert:edit_advert_details.html.twig',
            [
                'form'       => $form->createView(),
                'advert'     => $advert,
                'uploadForm' => $this->createForm(UploadPhotoForm::class)->createView(),
            ]
        );
    }


    public function viewAdvertAction(Request $request, $advertId)
    {
        $adModel = $this->getModel();

        //$form = $this->createForm(EditAdForm::class, $formOptions);
        $advertEnt = $adModel->getAdvertById($advertId);
        $this->getModel()->incrementViewed($advertEnt);

        if ($request->isMethod('POST')) {

        }

        return $this->render(
            'VelovitoBundle:advert:view_advert.html.twig',
            [
                'advert' => $advertEnt,
                'attributes' =>$adModel->getAdvertAttributesArray($advertEnt)
            ]
        );
    }


    public function viewCategoryAction(Request $request)
    {
        $id = (int)$request->get('id');

        if (empty($id)) {
            return $this->redirectToRoute('homepage');
        }

        return $this->render(
            'VelovitoBundle:default:index.html.twig',
            [
                'ads' => $this->getModel()->getLastAdvertsFromCategory($id),
            ]
        );
    }


    public function searchAdvertAction(Request $request)
    {


        $search = $request->get('search');

        return $this->render(
            'VelovitoBundle:advert:search.html.twig',
            [
                'ads' => $this->getModel()->searchAdverts($request),
            ]
        );
    }


    /**
     * @return AdvertisementModel
     */
    private function getModel()
    {
        return $this->get(C::MODEL_ADVERTISEMENT);
    }
}
