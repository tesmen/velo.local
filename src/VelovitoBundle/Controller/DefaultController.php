<?php

namespace VelovitoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('VelovitoBundle:Default:index.html.twig');
    }
}
