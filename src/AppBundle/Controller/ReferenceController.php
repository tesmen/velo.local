<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\Ad\AdNewForm;

class ReferenceController extends Controller
{
    /**
     * @Route("/reference-list", name="ad_list")
     */
    public function adListAction(Request $request)
    {

        return $this->render(
            'reference/reference_list.html.twig',
            [
                'ads' => $this->get('advertisement_model')->getAllAds(),
            ]
        );
    }

    /**
     * @Route("/reference-new", name="reference_new")
     */
    public function adNewAction(Request $request)
    {
        $form = $this->createForm(AdNewForm::class);

        try{
            if($request->isMethod('POST')){
                $form->handleRequest($request);
                $this->get('advertisement_model')->createAd($form->getData());
                return $this->redirectToRoute('ad_list');
            }
        }catch (\Exception $e){
            var_dump($e->getMessage());
        }

        return $this->render(
            'reference/reference_new.html.twig',
            [
                'form' => $form->createView(),
                'ads' => $this->get('advertisement_model')->getAllAds(),
            ]
        );
    }

    /**
     * @Route("/reference-view/{referenceId}", name="reference_view")
     */
    public function adViewAction(Request $request, $adId)
    {
        return $this->render(
            'reference/reference_view.html.twig',
            [
                'ad' => $this->get('advertisement_model')->getAdById($adId),
            ]
        );
    }
}
