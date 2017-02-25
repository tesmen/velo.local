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
        $repo = $this->get('doctrine.orm.default_entity_manager')->getRepository(C::REPO_CATEGORY);


        return $this->render(
            'VelovitoBundle:default:menu.html.twig',
            [
                C::PAGE_TITLE => $title,
                'menu'        => $repo->getActiveCatsWithProductsForMenu(),
            ]
        );
    }

    public function headerAction(Request $request, $title = null)
    {
        return $this->render(
            'VelovitoBundle:default:header.html.twig',
            [
                'menu'        => $this->get(C::MODEL_DEFAULT)->getMenu(),
                'categories'  => $this->get('model.advertisement')->getCategoriesList(),
            ]
        );
    }

    public function breadcrumbsAction(Request $request, $title = null)
    {
        return $this->render(
            'VelovitoBundle:default:breadcrumbs.html.twig',
            [
                C::PAGE_TITLE => $title,
                'menu'        => $this->get(C::MODEL_DEFAULT)->getMenu(),
                'categories'  => $this->get('model.advertisement')->getCategoriesList(),
            ]
        );
    }

    public function newsPanelAction(Request $request, $title = null)
    {
        return $this->render(
            'VelovitoBundle:default:news_panel.html.twig',
            [
                'news'  => $this->get('model.social')->getTenNews(),
            ]
        );
    }

    public function indexAction(Request $request)
    {
        return $this->render(
            'VelovitoBundle:default:index.html.twig',
            [
                'ads' => $this->get(C::MODEL_ADVERTISEMENT)->getLastAdverts(),
                'popularAdverts' => $this->get(C::MODEL_ADVERTISEMENT)->getPopular(3),
            ]
        );
    }
}
