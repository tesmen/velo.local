<?php

namespace VelovitoBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

trait AjaxControllerTrait
{
    private function standardJsonArray($status = true, $data = [], $message = '')
    {
        return new JsonResponse([
            AjaxController::F_STATUS  => (Bool)$status,
            AjaxController::F_DATA    => $data,
            AjaxController::F_MESSAGE => (String)$message,
        ]);
    }

    private function jsonSuccess($data = [])
    {
        return $this->standardJsonArray(true, $data);
    }

    private function jsonFailure($message)
    {
        return $this->standardJsonArray(false, [], $message);
    }

    private function fromPayload($request = null)
    {
        if (empty($request)) {
            $request = $this->container->get('request_stack')->getCurrentRequest();
        }

        return json_decode($request->getContent(), true);
    }
}
