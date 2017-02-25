<?php

namespace VelovitoBundle\Controller;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
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
use VelovitoBundle\Repository\GeneralRepository;

class AdminController extends GeneralController
{
    use AjaxControllerTrait;

    private function getQueryBuilder()
    {
        return $this->container->get('doctrine.orm.default_entity_manager')->getConnection()->createQueryBuilder();
    }

    public function dashBoardAction()
    {
        return $this->render('@Velovito/admin/dashboard.html.twig');
    }

    public function getAction(Request $request, $tableName, $id)
    {
        $query = $this->getQueryBuilder()
            ->select('*')
            ->from($tableName);

        if ($id) {
            $query->where(sprintf("id = %d", $id));
            $data = $query->execute()->fetch();
        } else {
            $data = $query->execute()->fetchAll();
        }

        return $this->jsonSuccess($data);
    }

    public function postAction(Request $request, $tableName, $id)
    {
        $post = $this->fromPayload($request);
        $data = $this->get(C::MODEL_ADMIN)->insert($tableName, $post);

        return $this->jsonSuccess($data);
    }

    /**
     * @param $entity
     * @return EntityRepository | GeneralRepository
     */
    private function getRepositoryByName($entity)
    {
        $repoClass = 'VelovitoBundle\Entity\\' . ucfirst($entity);

        if (class_exists($repoClass)) {
            return $this->getDoctrine()->getRepository($repoClass);
        }

        return null;
    }
}
