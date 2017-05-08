<?php

declare(strict_types=1);

namespace spec\AppBundle\Search\Elastic\Applicator\Query;

use AppBundle\Search\Criteria\Criteria;
use AppBundle\Search\Elastic\Applicator\Query\MatchProductApplicator;
use AppBundle\Search\Elastic\Applicator\SearchCriteriaApplicatorInterface;
use AppBundle\Search\Elastic\Factory\Query\QueryFactoryInterface;
use ONGR\ElasticsearchDSL\Query\FullText\MatchQuery;
use ONGR\ElasticsearchDSL\Search;
use PhpSpec\ObjectBehavior;

final class MatchProductApplicatorSpec extends ObjectBehavior
{
    function let(QueryFactoryInterface $matchProductNameQueryFactory): void
    {
        $this->beConstructedWith($matchProductNameQueryFactory);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(MatchProductApplicator::class);
    }

    function it_is_criteria_search_applicator(): void
    {
        $this->shouldImplement(SearchCriteriaApplicatorInterface::class);
    }

    function it_applies_match_product_by_name_query(
        QueryFactoryInterface $matchProductNameQueryFactory,
        MatchQuery $matchQuery,
        Search $search
    ): void {
        $criteria = Criteria::fromQueryParameters('product', ['search' => 'banana']);
        $matchProductNameQueryFactory->create(['search' => 'banana'])->willReturn($matchQuery);
        $search->addQuery($matchQuery)->shouldBeCalled();

        $this->apply($criteria, $search);
    }

    function it_supports_criteria_with_search_parameter(): void
    {
        $criteria = Criteria::fromQueryParameters('product', ['search' => 'banana']);

        $this->supports($criteria)->shouldReturn(true);
    }
}
