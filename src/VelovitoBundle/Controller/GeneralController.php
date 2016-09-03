<?php

namespace VelovitoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use VelovitoBundle\C;
use VelovitoBundle\Entity\AbstractAttribute;
use VelovitoBundle\Entity\Advertisement;
use VelovitoBundle\Form\Advert\FillAdvertForm;

class GeneralController extends Controller
{
    protected function isAuthenticatedFully()
    {
        return $this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY');
    }

    protected function denyUnlessAuthenticatedFully()
    {
        if (!$this->isAuthenticatedFully()) {
            throw $this->createAccessDeniedException();
        }
    }

    protected function getCurrentRoute()
    {
        return $this->get('request_stack')->getCurrentRequest()->get('_route');
    }

    protected function redirectToThis($attr = [])
    {
        return $this->redirectToRoute($this->getCurrentRoute(), $attr);
    }

    protected function returnJsonResponse($status, $data = null, $message = null)
    {
        return new JsonResponse([
            'status'  => $status,
            'data'    => $data,
            'message' => $message,
        ]);
    }

    protected function canUserEditAdvert(Advertisement $advertEnt)
    {
        if (!$this->get(C::MODEL_ADVERTISEMENT)->userCanEditAdvert($advertEnt)) {
            $this->addFlash(C::FLASH_ERROR, 'Что-то пошло не так...');

            throw $this->createNotFoundException();
        }
    }


    protected function createAdvertDetailsForm(Advertisement $advert, $fill = false)
    {
        $adModel = $this->get(C::MODEL_ADVERTISEMENT);
        $options[C::FORM_ATTRIBUTE_LIST] = $adModel->getAttributesByProductId($advert->getProduct()->getId());

        if ($fill) {
            foreach ($advert->getAttributes() as $attribute) {
                $options[AbstractAttribute::FORM_PREFIX . $attribute->getAttribute()->getId()] = $attribute->getValue();
            }
        }

        $form = $this->createForm(FillAdvertForm::class, $options);


        return $form;
    }
}
