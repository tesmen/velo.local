<?php

namespace VelovitoBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use VelovitoBundle\C;

class DefaultController extends Controller
{
    public function velovitoAction(Request $request)
    {
        return $this->render(
            'VelovitoBundle:default:velovito.html.twig',
            [
                'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            ]
        );
    }

    public function indexAction(Request $request)
    {
        return $this->render(
            'VelovitoBundle:default:index.html.twig',
            [
                'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            ]
        );
    }

    public function menuAction(Request $request, $currentPath, $title = null)
    {

        $this->get(C::MODEL_DEFAULT)->getMenu($request->get('catId'));

        return $this->render(
            'VelovitoBundle:default:menu.html.twig',
            [
                C::PAGE_TITLE => $title,
                'currentPath' => $currentPath,
            ]
        );
    }
}
