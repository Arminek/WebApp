<?php

declare(strict_types=1);

namespace spec\AppBundle\Search\Elastic\Applicator\Filter;

use AppBundle\Search\Criteria\Criteria;
use AppBundle\Search\Elastic\Applicator\Filter\ProductInPriceRangeApplicator;
use AppBundle\Search\Elastic\Applicator\SearchCriteriaApplicatorInterface;
use AppBundle\Search\Elastic\Factory\Query\QueryFactoryInterface;
use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use ONGR\ElasticsearchDSL\Query\TermLevel\RangeQuery;
use ONGR\ElasticsearchDSL\Search;
use PhpSpec\ObjectBehavior;

final class ProductInPriceRangeApplicatorSpec extends ObjectBehavior
{
    function let(QueryFactoryInterface $productInPriceRangeQueryFactory): void
    {
        $this->beConstructedWith($productInPriceRangeQueryFactory);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(ProductInPriceRangeApplicator::class);
    }

    function it_is_search_criteria_applicator(): void
    {
        $this->shouldImplement(SearchCriteriaApplicatorInterface::class);
    }

    function it_applies_search_criteria_for_given_query(QueryFactoryInterface $productInPriceRangeQueryFactory, Search $search, RangeQuery $rangeQuery): void
    {
        $criteria = Criteria::fromQueryParameters('product', ['product_price_range' => ['grater_than' => 20, 'less_than' => 50]]);

        $productInPriceRangeQueryFactory->create(['product_price_range' => ['grater_than' => 20, 'less_than' => 50]])->willReturn($rangeQuery);
        $search->addPostFilter($rangeQuery, BoolQuery::MUST)->shouldBeCalled();

        $this->apply($criteria, $search);
    }

    function it_supports_criteria_when_it_has_all_query_parameters(): void
    {
        $criteria = Criteria::fromQueryParameters('product', ['product_price_range' => ['grater_than' => 20, 'less_than' => 50]]);

        $this->supports($criteria)->shouldReturn(true);
    }

    function it_does_not_support_criteria_when_product_price_range_parameter_is_missing(): void
    {
        $criteria = Criteria::fromQueryParameters('product', ['taxon_code' => 'mugs']);

        $this->supports($criteria)->shouldReturn(false);
    }

    function it_does_not_support_criteria_when_grater_than_paramter_is_missing(): void
    {
        $criteria = Criteria::fromQueryParameters('product', ['product_price_range' => ['less_than' => 50]]);

        $this->supports($criteria)->shouldReturn(false);
    }

    function it_does_not_support_criteria_when_less_than_paramter_is_missing(): void
    {
        $criteria = Criteria::fromQueryParameters('product', ['product_price_range' => ['grater_than' => 50]]);

        $this->supports($criteria)->shouldReturn(false);
    }
}
