<?php

namespace VelovitoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use VelovitoBundle\C;
use VelovitoBundle\Form\Ad\EditAdForm;

class AdvertController extends GeneralController
{
    public function viewAdvertAction(Request $request, $advertId)
    {
        $adModel = $this->get(C::MODEL_ADVERTISEMENT);

        $advertEnt = $this->get(C::MODEL_ADVERTISEMENT)->getAdById($advertId);

        $formOptions = [
            'obj'         => $advertEnt,
            'ad_statuses' => $adModel->getAdStatusMap(),
            'categories'  => $this->get(C::MODEL_DEFAULT)->getMenu(),
        ];

        $form = $this->createForm(EditAdForm::class, $formOptions);
        $advertEnt = $this->get(C::MODEL_ADVERTISEMENT)->incrementViewed($advertEnt);
        if ($request->isMethod('POST')) {

        }

        return $this->render(
            'VelovitoBundle:user:new_ad.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}