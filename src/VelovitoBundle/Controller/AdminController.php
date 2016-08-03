<?php

namespace VelovitoBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use VelovitoBundle\Entity\ProductAttribute;
use VelovitoBundle\Form\Admin\EditAttributeForm;
use VelovitoBundle\Form\Admin\EditCategoryForm;
use VelovitoBundle\Form\Admin\EditProductForm;
use VelovitoBundle\Form\Admin\EditReferenceForm;
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

        return $this->render('@Velovito/admin/edit_product.html.twig', [
            'form' => $form->createView(),
            'items' => $model->getAttributesMapByProductId($id),
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

        $form = $this->createForm(NewAttributeForm::class, [
            C::FORM_REFERENCE_LIST => $model->getAttrReferencesForForm()
        ]);

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
            'items'          => $model->getAlLProductAttributes(),
            'form'           => $form->createView(),
        ]);
    }


    public function editAttributeAction(Request $request, $id)
    {
        $model = $this->get(C::MODEL_ADMIN);
        $ent = $model->getProductAttributeById($id);
        $form = $this->createForm(EditAttributeForm::class, [
            C::FORM_TITLE => $ent->getName(),
            C::FORM_COMMENT => $ent->getComment(),
            C::FORM_REFERENCE_LIST => $model->getAttrReferencesForForm(),
        ]);

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

        return $this->render('@Velovito/admin/edit_attribute.html.twig', [
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
                $model->createOrUpdateReference($formData);
                $this->addFlash(C::FLASH_SUCCESS, 'ok!');

                return $this->redirectToThis();
            } catch (\Exception $e) {
                $this->addFlash(C::FLASH_ERROR, $e->getMessage());
                throw $e;
            }
        }

        return $this->render('@Velovito/admin/list_attribute_references.html.twig', [
            'items' => $model->getAllAttributeReferences(),
            'form'  => $form->createView(),
        ]);
    }


    public function editReferenceAction(Request $request, $id)
    {
        $model = $this->get(C::MODEL_ADMIN);
        $ent = $model->getAttributeReferenceById($id);
        $form = $this->createForm(EditReferenceForm::class);

        $form->setData(
            [
                C::FORM_TITLE     => $ent->getName(),
                C::FORM_COMMENT   => $ent->getComment(),
                C::FORM_IS_ACTIVE => $ent->getActive(),
            ]
        );

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            $formData = $form->getData();

            if ($form->getClickedButton()->getName() === C::FORM_ADD) {
                try {
                    $formData[C::FORM_REFERENCE] = $id;
                    $model->createOrUpdateReferenceItem($formData);
                    $this->addFlash(C::FLASH_SUCCESS, 'item ok!');

                    return $this->redirectToThis(['id' => $id]);
                } catch (\Exception $e) {
                    $this->addFlash(C::FLASH_ERROR, $e->getMessage());
                    throw $e;
                }
            } else {
                try {
                    $model->createOrUpdateReference($formData, $ent);
                    $this->addFlash(C::FLASH_SUCCESS, 'ok!');

                    return $this->redirectToThis(['id' => $id]);
                } catch (\Exception $e) {
                    $this->addFlash(C::FLASH_ERROR, $e->getMessage());
                    throw $e;
                }
            }

        }

        return $this->render('@Velovito/admin/edit_attribute_reference.html.twig', [
            'items' => $model->getAllReferenceItems($id),
            'form'  => $form->createView(),
        ]);
    }


    public function toggleReferenceItemStatusAction(Request $request)
    {
        $action = $request->get('action');
        $id = $request->get('id');
        $model = $this->get(C::MODEL_ADMIN);

        try {
            $model->toggleReferenceItemStatus($id, (int)$action);

            //todo AJAX
            return $this->redirectToRoute('admin_edit_reference',[
                'id' => $model->getReferenceIdByItemId($id)
            ]);
//            return $this->returnJsonResponse(true);
        } catch (\Exception $e) {
            return $this->returnJsonResponse(false, null, $e->getMessage());
        }
    }
}
