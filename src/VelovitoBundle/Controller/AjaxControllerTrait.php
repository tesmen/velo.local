<?php

namespace VelovitoBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use VelovitoBundle\Form\Ajax\UploadPhotoForm;
use VelovitoBundle\C;

trait AjaxControllerTrait
{
    private function standardJsonArray($status = true, array $data = [], $message = '')
    {
        return new JsonResponse( [
            AjaxController::F_STATUS  => (Bool)$status,
            AjaxController::F_DATA    => (Array)$data,
            AjaxController::F_MESSAGE => (String)$message,
        ]);
    }

    private function jsonSuccess($data)
    {
        return $this->standardJsonArray(true, $data);
    }

    private function jsonFailure($message)
    {
        return $this->standardJsonArray(true, [], $message);
    }
}
