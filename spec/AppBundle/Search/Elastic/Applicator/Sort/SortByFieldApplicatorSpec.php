<?php

declare(strict_types=1);

namespace spec\AppBundle\Search\Elastic\Applicator\Sort;

use AppBundle\Search\Criteria\Criteria;
use AppBundle\Search\Elastic\Applicator\SearchCriteriaApplicatorInterface;
use AppBundle\Search\Elastic\Applicator\Sort\SortByFieldApplicator;
use AppBundle\Search\Elastic\Factory\Sort\SortFactoryInterface;
use ONGR\ElasticsearchDSL\Search;
use ONGR\ElasticsearchDSL\Sort\FieldSort;
use PhpSpec\ObjectBehavior;

final class SortByFieldApplicatorSpec extends ObjectBehavior
{
    function let(SortFactoryInterface $sortByFieldSortFactory): void
    {
        $this->beConstructedWith($sortByFieldSortFactory);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(SortByFieldApplicator::class);
    }

    function it_is_search_criteria_applicator(): void
    {
        $this->shouldImplement(SearchCriteriaApplicatorInterface::class);
    }

    function it_applies_sort_query_to_search_with_given_sorting(
        SortFactoryInterface $sortByFieldSortFactory,
        Search $search,
        FieldSort $fieldSort
    ): void {
        $criteria = Criteria::fromQueryParameters('product', ['sort' => '-name']);
        $sortByFieldSortFactory->create($criteria->ordering())->willReturn($fieldSort);
        $search->addSort($fieldSort)->shouldBeCalled();

        $this->apply($criteria, $search);
    }

    function it_supports_criteria_with_sort_parameter(): void
    {
        $criteria = Criteria::fromQueryParameters('product', ['sort' => '-name']);

        $this->supports($criteria)->shouldReturn(true);
    }

    function it_support_sorting_by_default(): void
    {
        $criteria = Criteria::fromQueryParameters('product', []);

        $this->supports($criteria)->shouldReturn(true);
    }
}
