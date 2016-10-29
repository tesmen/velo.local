<?php

namespace VelovitoBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use VelovitoBundle\Form\Ajax\UploadPhotoForm;
use VelovitoBundle\C;

class AjaxController extends GeneralController
{
    const F_STATUS = 'status';
    const F_DATA = 'data';
    const F_MESSAGE = 'message';

    const F_LIMIT_DEFAULT = 50;

    public function uploadPhotoAction(Request $request)
    {
        $form = $this->createForm(UploadPhotoForm::class);
        $form->handleRequest($request);
        $data = $form->getData();
        $filename = $this->get(C::MODEL_DOCUMENT)->saveUploadedFile($data[C::FORM_PHOTO]);

        return new JsonResponse($filename);
    }
}