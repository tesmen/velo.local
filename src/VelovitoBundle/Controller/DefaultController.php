<?php

namespace VelovitoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use VelovitoBundle\C;

class DefaultController extends GeneralController
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

    public function menuAction(Request $request, $title = null)
    {
        $menu = $this->get(C::MODEL_DEFAULT)->getMenu();

        return $this->render(
            'VelovitoBundle:default:menu.html.twig',
            [
                C::PAGE_TITLE => $title,
                'menu'        => $menu,
            ]
        );
    }

    public function headerAction(Request $request, $title = null)
    {
        $menu = $this->get(C::MODEL_DEFAULT)->getMenu();

        return $this->render(
            'VelovitoBundle:default:header.html.twig',
            [
                C::PAGE_TITLE => $title,
                'menu'        => $menu,
            ]
        );
    }

    public function indexAction(Request $request)
    {
        return $this->render(
            'VelovitoBundle:default:index.html.twig',
            [
                'ads' => $this->get(C::MODEL_ADVERTISEMENT)->getFewLastAds(),
            ]
        );
    }
}
