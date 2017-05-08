<?php

declare(strict_types=1);

namespace AppBundle\Search\Elastic\Applicator\Query;

use AppBundle\Search\Criteria\Criteria;
use AppBundle\Search\Elastic\Applicator\SearchCriteriaApplicatorInterface;
use AppBundle\Search\Elastic\Factory\Query\QueryFactoryInterface;
use ONGR\ElasticsearchDSL\Search;

final class MatchProductApplicator implements SearchCriteriaApplicatorInterface
{
    /**
     * @var QueryFactoryInterface
     */
    private $matchProductNameQueryFactory;

    /**
     * @param QueryFactoryInterface $matchProductNameQueryFactory
     */
    public function __construct(QueryFactoryInterface $matchProductNameQueryFactory)
    {
        $this->matchProductNameQueryFactory = $matchProductNameQueryFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function apply(Criteria $criteria, Search $search): void
    {
        $search->addQuery($this->matchProductNameQueryFactory->create($criteria->filtering()->fields()));
    }

    /**
     * {@inheritdoc}
     */
    public function supports(Criteria $criteria): bool
    {
        return
            array_key_exists('search', $criteria->filtering()->fields()) &&
            null != $criteria->filtering()->fields()['search']
        ;
    }
}
