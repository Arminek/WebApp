<?php

declare(strict_types=1);

namespace AppBundle\Search\Elastic\Applicator\Query;

use AppBundle\Search\Criteria\Criteria;
use AppBundle\Search\Elastic\Applicator\SearchCriteriaApplicatorInterface;
use AppBundle\Search\Elastic\Factory\Query\QueryFactoryInterface;
use ONGR\ElasticsearchDSL\Search;

final class EmptyCriteriaApplicator implements SearchCriteriaApplicatorInterface
{
    /**
     * @var QueryFactoryInterface
     */
    private $emptyCriteriaQueryFactory;

    /**
     * @param QueryFactoryInterface $emptyCriteriaQueryFactory
     */
    public function __construct(QueryFactoryInterface $emptyCriteriaQueryFactory)
    {
        $this->emptyCriteriaQueryFactory = $emptyCriteriaQueryFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(Criteria $criteria): bool
    {
        return !array_key_exists('search', $criteria->filtering()->fields());
    }

    /**
     * {@inheritdoc}
     */
    public function apply(Criteria $criteria, Search $search): void
    {
        $search->addQuery($this->emptyCriteriaQueryFactory->create());
    }
}
