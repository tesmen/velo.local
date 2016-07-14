<?php

namespace VelovitoBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use VelovitoBundle\Form\Ajax\UploadPhotoForm;
use VelovitoBundle\C;

class AdminController extends GeneralController
{
    public function dashBoardAction(Request $request)
    {


        return $this->render('@Velovito/admin/dashboard.html.twig');
    }


    public function editProducts(Request $request)
    {


        return $this->render('@Velovito/admin/dashboard.html.twig');
    }
}