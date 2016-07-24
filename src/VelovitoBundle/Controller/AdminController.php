<?php

namespace VelovitoBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use VelovitoBundle\Form\Admin\EditCategoryForm;
use VelovitoBundle\Form\Admin\NewCategoryForm;
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

                return $this->redirectToThis();
            } catch (\Exception $e) {
                $this->addFlash(C::FLASH_ERROR, $e->getMessage());
            }
        }

        return $this->render('@Velovito/admin/edit_product.html.twig', [
            'attributes' => $this->get('model.admin')->getProductAttributesByProductId($product->getId()),
            'form'       => $form->createView(),

        ]);
    }


    public function editCategoryAction(Request $request, $id)
    {
        $model = $this->get(C::MODEL_ADMIN);
        $category = $model->getProductById($id);
        $form = $this->createForm(EditCategoryForm::class);

        $form->setData(
            [
                C::FORM_TITLE     => $category->getName(),
                C::FORM_IS_ACTIVE => $category->getActive(),
            ]
        );

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            $formData = $form->getData();

//            try {
                $model->updateCategory($id, $formData);
                $this->addFlash(C::FLASH_SUCCESS, 'ok!');

                return $this->redirectToThis();
//            } catch (\Exception $e) {
//                $this->addFlash(C::FLASH_ERROR, $e->getMessage());
//            }
        }

        return $this->render('@Velovito/admin/edit_category.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    public function listProductsAction(Request $request)
    {
        $model = $this->get(C::MODEL_ADMIN);
        $options[C::FORM_CATEGORY_LIST] = $model->getCategoriesForForm();
        $form = $this->createForm(ProductForm::class, $options);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            $formData = $form->getData();

            try {
                $model->createProduct($formData);
                $this->addFlash(C::FLASH_SUCCESS, 'ok!');

                return $this->redirectToThis();
            } catch (\Exception $e) {
                $this->addFlash(C::FLASH_ERROR, $e->getMessage());
            }
        }

        return $this->render('@Velovito/admin/list_products.html.twig', [
            'products' => $model->getAllProducts(),
            'form'     => $form->createView(),
        ]);
    }


    public function listCategoriesAction(Request $request)
    {
        $model = $this->get(C::MODEL_ADMIN);

        $form = $this->createForm(NewCategoryForm::class);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            $formData = $form->getData();

            try {
                $model->createCategory($formData[C::FORM_TITLE]);
                $this->addFlash(C::FLASH_SUCCESS, 'ok!');

                return $this->redirectToThis();
            } catch (\Exception $e) {
                $this->addFlash(C::FLASH_ERROR, $e->getMessage());
            }
        }

        return $this->render('@Velovito/admin/list_categories.html.twig', [
            'categories' => $model->getAllCategories(),
            'form'       => $form->createView(),
        ]);
    }
}
