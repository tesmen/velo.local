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

        //$form = $this->createForm(EditAdForm::class, $formOptions);
        $advertEnt = $this->get(C::MODEL_ADVERTISEMENT)->getAdById($advertId);
        $this->get(C::MODEL_ADVERTISEMENT)->incrementViewed($advertEnt);

        if ($request->isMethod('POST')) {

        }

        return $this->render(
            'VelovitoBundle:advert:view_ad.html.twig',
            [
                'advert' => $advertEnt,
            ]
        );
    }
}