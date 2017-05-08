<?php

declare(strict_types=1);

namespace AppBundle\Search\Elastic\Applicator\Filter;

use AppBundle\Search\Criteria\Criteria;
use AppBundle\Search\Elastic\Applicator\SearchCriteriaApplicatorInterface;
use AppBundle\Search\Elastic\Factory\Query\QueryFactoryInterface;
use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use ONGR\ElasticsearchDSL\Search;

final class ProductInPriceRangeApplicator implements SearchCriteriaApplicatorInterface
{
    /**
     * @var QueryFactoryInterface
     */
    private $productInPriceRangeQueryFactory;

    /**
     * @param QueryFactoryInterface $productInPriceRangeQueryFactory
     */
    public function __construct(QueryFactoryInterface $productInPriceRangeQueryFactory)
    {
        $this->productInPriceRangeQueryFactory = $productInPriceRangeQueryFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function apply(Criteria $criteria, Search $search): void
    {
        $search->addPostFilter($this->productInPriceRangeQueryFactory->create($criteria->filtering()->fields()), BoolQuery::MUST);
    }

    /**
     * {@inheritdoc}
     */
    public function supports(Criteria $criteria): bool
    {
        $filteringFields = $criteria->filtering()->fields();

        return
            array_key_exists('product_price_range', $filteringFields) &&
            array_key_exists('grater_than', $filteringFields['product_price_range']) &&
            array_key_exists('less_than', $filteringFields['product_price_range']);
    }
}
