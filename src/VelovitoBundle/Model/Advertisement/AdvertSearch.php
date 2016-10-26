<?php

namespace VelovitoBundle\Model\Advertisement;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;
use VelovitoBundle\Model\SearchModelInterface;

class AdvertSearch implements SearchModelInterface
{
    private $qb;
    private $request;

    public function __construct(EntityRepository $repo, Request $request)
    {
        $this->qb = $repo->createQueryBuilder('q');
        $this->request = $request;
    }

    /**
     * @return array
     */
    private function getRules()
    {
        $qb = $this->qb;

        $rules = [
            'search'      => function ($param) use ($qb) {
                $qb->andWhere('q.title LIKE :title')
                    ->setParameter('title', '%' . $param . '%');
            },
            'category_id' => function ($param) use ($qb) {
                $qb->andWhere('q.category = :category_id')
                    ->setParameter('category_id', $param);
            },
            'product_id'  => function ($param) use ($qb) {
                $qb->andWhere('q.product = :product_id')
                    ->setParameter('product_id', $param);
            },
        ];

        return $rules;
    }

    public function buildQuery()
    {
        $requestParams  = $this->request->query->all();

        foreach ($this->getRules() as $paramName => $closure) {
            if (!isset($requestParams[$paramName])) {
                continue;
            }

            $closure($requestParams[$paramName]);
        }

        $this->qb->addOrderBy('q.created','DESC');

        return $this->qb->getQuery();
    }
}
