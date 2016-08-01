<?php

namespace VelovitoBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use VelovitoBundle\Entity\ProductAttribute;
use VelovitoBundle\Form\Admin\EditCategoryForm;
use VelovitoBundle\Form\Admin\EditProductForm;
use VelovitoBundle\Form\Admin\NewAttributeForm;
use VelovitoBundle\Form\Admin\NewCategoryForm;
use VelovitoBundle\Form\Admin\NewReferenceForm;
use VelovitoBundle\Form\Admin\NewProductForm;
use VelovitoBundle\C;

class AdminController extends GeneralController
{
    public function dashBoardAction(Request $request)
    {
        return $this->render('@Velovito/admin/dashboard.html.twig');
    }


    public function editProductAction(Request $request, $id)
    {
        $model = $this->get(C::MODEL_ADMIN);
        $product = $model->getProductById($id);

        $options = [
            C::FORM_CATEGORY_LIST => $model->getCategoriesForForm(),
            C::FORM_TITLE         => $product->getName(),
            C::FORM_IS_ACTIVE     => $product->getActive(),
            C::FORM_CATEGORY      => $product->getCategory()->getId(),
        ];

        $form = $this->createForm(EditProductForm::class, $options);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            $formData = $form->getData();

            try {
                $model->updateProduct($id, $formData);
                $this->addFlash(C::FLASH_SUCCESS, 'ok!');

                return $this->redirectToThis(
                    ['id' => $id]
                );
            } catch (\Exception $e) {
                $this->addFlash(C::FLASH_ERROR, $e->getMessage());
            }
        }

        return $this->render('@Velovito/admin/edit_category.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    public function editCategoryAction(Request $request, $id)
    {
        $model = $this->get(C::MODEL_ADMIN);
        $category = $model->getCategoryById($id);
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

            try {
                $model->updateCategory($id, $formData);
                $this->addFlash(C::FLASH_SUCCESS, 'ok!');

                return $this->redirectToThis(
                    ['id' => $id]
                );
            } catch (\Exception $e) {
                $this->addFlash(C::FLASH_ERROR, $e->getMessage());
            }
        }

        return $this->render('@Velovito/admin/edit_category.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    public function listProductsAction(Request $request)
    {
        $model = $this->get(C::MODEL_ADMIN);
        $options[C::FORM_CATEGORY_LIST] = $model->getCategoriesForForm();
        $form = $this->createForm(NewProductForm::class, $options);

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


    public function listAttributesAction(Request $request)
    {
        $model = $this->get(C::MODEL_ADMIN);
        $options[C::FORM_ATTRIBUTE_TYPE_LIST] = $model->getAllAttributeVariants();

        $form = $this->createForm(NewAttributeForm::class, $options);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            $formData = $form->getData();

            try {
                $model->createProductAttribute($formData);
                $this->addFlash(C::FLASH_SUCCESS, 'ok!');

                return $this->redirectToThis();
            } catch (\Exception $e) {
                $this->addFlash(C::FLASH_ERROR, $e->getMessage());
                throw $e;
            }
        }

        return $this->render('@Velovito/admin/list_attributes.html.twig', [
            'attributeTypes' => ProductAttribute::getTypesList(),
            'items'          => $model->getAllAttributes(),
            'form'           => $form->createView(),
        ]);
    }


    public function listReferencesAction(Request $request)
    {
        $model = $this->get(C::MODEL_ADMIN);
        $form = $this->createForm(NewReferenceForm::class);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            $formData = $form->getData();

            try {
                $model->createProductAttribute($formData);
                $this->addFlash(C::FLASH_SUCCESS, 'ok!');

                return $this->redirectToThis();
            } catch (\Exception $e) {
                $this->addFlash(C::FLASH_ERROR, $e->getMessage());
                throw $e;
            }
        }

        return $this->render('@Velovito/admin/list_attribute_variant_lists.html.twig', [
            'items' => $model->getAllAttributeVariantLists(),
            'form'       => $form->createView(),
        ]);
    }


    public function editReferenceAction(Request $request, $id)
    {
        $model = $this->get(C::MODEL_ADMIN);
        $category = $model->getCategoryById($id);
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

            try {
                $model->updateCategory($id, $formData);
                $this->addFlash(C::FLASH_SUCCESS, 'ok!');

                return $this->redirectToThis(
                    ['id' => $id]
                );
            } catch (\Exception $e) {
                $this->addFlash(C::FLASH_ERROR, $e->getMessage());
            }
        }

        return $this->render('@Velovito/admin/edit_category.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
