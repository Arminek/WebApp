<?php

declare(strict_types=1);

namespace spec\AppBundle\Search\Elastic\Applicator\Query;

use AppBundle\Search\Criteria\Criteria;
use AppBundle\Search\Elastic\Applicator\Query\EmptyCriteriaApplicator;
use AppBundle\Search\Elastic\Applicator\SearchCriteriaApplicatorInterface;
use AppBundle\Search\Elastic\Factory\Query\QueryFactoryInterface;
use ONGR\ElasticsearchDSL\Query\MatchAllQuery;
use ONGR\ElasticsearchDSL\Search;
use PhpSpec\ObjectBehavior;

final class EmptyCriteriaApplicatorSpec extends ObjectBehavior
{
    function let(QueryFactoryInterface $matchAllQueryFactory): void
    {
        $this->beConstructedWith($matchAllQueryFactory);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(EmptyCriteriaApplicator::class);
    }

    function it_is_search_criteria_applicator(): void
    {
        $this->shouldImplement(SearchCriteriaApplicatorInterface::class);
    }

    function it_supports_criteria_if_they_satisfies_specification(): void
    {
        $criteria = Criteria::fromQueryParameters('product', []);

        $this->supports($criteria)->shouldReturn(true);
    }

    function it_does_not_support_criteria_if_they_do_not_satisfies_specification(): void
    {
        $criteria = Criteria::fromQueryParameters('product', ['search' => 'banana']);

        $this->supports($criteria)->shouldReturn(false);
    }

    function it_builds_search_query(
        QueryFactoryInterface $matchAllQueryFactory,
        Search $search,
        MatchAllQuery $matchAllQuery
    ): void {
        $criteria = Criteria::fromQueryParameters('product', []);

        $matchAllQueryFactory->create()->willReturn($matchAllQuery);
        $search->addQuery($matchAllQuery)->shouldBeCalled();

        $this->apply($criteria, $search);
    }
}
