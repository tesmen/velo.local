<?php

namespace VelovitoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use VelovitoBundle\C;

class DefaultController extends GeneralController
{
    public function velovitoAction(Request $request)
    {
        return $this->render(
            'VelovitoBundle:default:velovito.html.twig'
        );
    }

    public function menuAction(Request $request, $title = null)
    {
        return $this->render(
            'VelovitoBundle:default:menu.html.twig',
            [
                C::PAGE_TITLE => $title,
                'menu'        => $this->get(C::MODEL_DEFAULT)->getMenuParentCategories(),
            ]
        );
    }

    public function headerAction(Request $request, $title = null)
    {
        return $this->render(
            'VelovitoBundle:default:header.html.twig',
            [
                C::PAGE_TITLE => $title,
                'menu'        => $this->get(C::MODEL_DEFAULT)->getMenu(),
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
