<?php

namespace VelovitoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class GeneralController extends Controller
{
    public function isAuthenticatedFully()
    {
        return $this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY');
    }

    public function denyUnlessAuthenticatedFully()
    {
        if (!$this->isAuthenticatedFully()) {
            throw $this->createAccessDeniedException();
        }
    }

    public function getCurrentRoute()
    {
        return $this->get('request_stack')->getCurrentRequest()->get('_route');
    }

    public function redirectToThis($attr = [])
    {
        return $this->redirectToRoute($this->getCurrentRoute(), $attr);
    }

    public function returnJsonResponse($status, $data = null, $message = null)
    {
        return new JsonResponse([
            'status'  => $status,
            'data'    => $data,
            'message' => $message,
        ]);
    }
}
