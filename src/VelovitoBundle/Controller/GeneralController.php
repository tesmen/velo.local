<?php

namespace VelovitoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
}
