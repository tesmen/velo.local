<?php

namespace VelovitoBundle\Controller;

use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use VelovitoBundle\Form\Ajax\UploadPhotoForm;
use VelovitoBundle\C;

class AjaxController extends GeneralController
{
    public function uploadPhotoAction(Request $request)
    {
        $form = $this->createForm(UploadPhotoForm::class);
        $form->handleRequest($request);
        $data = $form->getData();

        return new JsonResponse(get_class($data[C::FORM_PHOTO]));
    }
}