<?php

namespace VelovitoBundle\Controller;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Symfony\Component\HttpFoundation\Request;
use VelovitoBundle\Repository\GeneralRepository;

class RestController extends GeneralController
{
    use AjaxControllerTrait;

    public function getAction(Request $request, $entityName, $id)
    {
        if (empty(($repo = $this->getRepositoryByName($entityName)))) {
            return $this->jsonFailure('entity not found');
        }

        if ($id) {
            $data = $repo
                ->createQueryBuilder('q')
                ->where('q.id = :id')
                ->setParameter('id', $id)
                ->getQuery()
                ->setHint(Query::HINT_INCLUDE_META_COLUMNS, true)
                ->getOneOrNullResult(Query::HYDRATE_ARRAY);

            return $this->jsonSuccess($data);
        }

        $limit = (int)$request->query->get('limit');
        $indexBy = $request->query->get('index_by');

        // todo no index by for REST
        $data = $repo
            ->createQueryBuilder('q', $indexBy ? "q.$indexBy" : null)
            ->setMaxResults($limit ?: AjaxController::F_LIMIT_DEFAULT)
            ->getQuery()
            ->setHint(Query::HINT_INCLUDE_META_COLUMNS, true)
            ->getResult(Query::HYDRATE_ARRAY);

        return $this->jsonSuccess($data);
    }

    /**
     * @deprecated
     * @param Request $request
     * @param $entityName
     * @param $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
      public function updateAction(Request $request, $entityName, $id)
    {
        if (empty(($repo = $this->getRepositoryByName($entityName)))) {
            return $this->jsonFailure('entity not found');
        }

        $data = $this->fromPayload($request);

        if (empty($data['entity'])) {
            return $this->jsonSuccess();
        }

        $data = $repo->update($data['entity'], $id);

        return $this->jsonSuccess($data);
    }

    public function postAction(Request $request, $entityName, $id)
    {
        if (empty(($repo = $this->getRepositoryByName($entityName)))) {
            return $this->jsonFailure('entity not found');
        }

        $data = $this->fromPayload($request);

        if (empty($data['entity'])) {
            return $this->jsonSuccess();
        }

        $data = $repo->update($data['entity'], $id);

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
