<?php

namespace VelovitoBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use VelovitoBundle\Form\Admin\ProductForm;
use VelovitoBundle\Form\Ajax\UploadPhotoForm;
use VelovitoBundle\C;

class AdminController extends GeneralController
{
    public function dashBoardAction(Request $request)
    {


        return $this->render('@Velovito/admin/dashboard.html.twig');
    }


    public function editProductAction(Request $request, $id)
    {
        $product = $this->get('model.admin')->getProductById($id);
        $form = $this->createForm(ProductForm::class);

        $form->setData(
            [C::FORM_TITLE => $product->getName()]
        );

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            $formData = $form->getData();

            try {
                $this->get('model.admin')->createProduct($formData[C::FORM_TITLE]);
                $this->addFlash(C::FLASH_SUCCESS, 'ok!');
            } catch (\Exception $e) {
                $this->addFlash(C::FLASH_ERROR, $e->getMessage());
            }
        }

        return $this->render('@Velovito/admin/edit_product.html.twig', [
            'attributes' => $this->get('model.admin')->getProductAttributesByProductId($product->getId()),
            'form'       => $form->createView(),

        ]);
    }


    public function listProductsAction(Request $request)
    {
        $form = $this->createForm(ProductForm::class);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            $formData = $form->getData();

            try {
                $this->get('model.admin')->createProduct($formData[C::FORM_TITLE]);
                $this->addFlash(C::FLASH_SUCCESS, 'ok!');
            } catch (\Exception $e) {
                $this->addFlash(C::FLASH_ERROR, $e->getMessage());
            }
        }

        return $this->render('@Velovito/admin/list_products.html.twig', [
            'products' => $this->get('model.admin')->getAllProducts(),
            'form'     => $form->createView(),
        ]);
    }
}