<?php

declare(strict_types=1);

namespace AppBundle\Search\Elastic\Applicator\Sort;

use AppBundle\Search\Criteria\Criteria;
use AppBundle\Search\Elastic\Applicator\SearchCriteriaApplicatorInterface;
use AppBundle\Search\Elastic\Factory\Sort\SortFactoryInterface;
use ONGR\ElasticsearchDSL\Search;

final class SortByFieldApplicator implements SearchCriteriaApplicatorInterface
{
    /**
     * @var SortFactoryInterface
     */
    private $sortByFieldQueryFactory;

    /**
     * @param SortFactoryInterface $sortByFieldQueryFactory
     */
    public function __construct(SortFactoryInterface $sortByFieldQueryFactory)
    {
        $this->sortByFieldQueryFactory = $sortByFieldQueryFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function apply(Criteria $criteria, Search $search): void
    {
        $search->addSort($this->sortByFieldQueryFactory->create($criteria->ordering()));
    }

    /**
     * {@inheritdoc}
     */
    public function supports(Criteria $criteria): bool
    {
        return null != $criteria->ordering()->field() && null != $criteria->ordering()->direction();
    }
}
