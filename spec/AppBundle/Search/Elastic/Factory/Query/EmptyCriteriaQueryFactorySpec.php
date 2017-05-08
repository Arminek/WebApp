<?php

declare(strict_types=1);

namespace spec\AppBundle\Search\Elastic\Factory\Query;

use AppBundle\Search\Elastic\Factory\Query\EmptyCriteriaQueryFactory;
use AppBundle\Search\Elastic\Factory\Query\QueryFactoryInterface;
use ONGR\ElasticsearchDSL\Query\MatchAllQuery;
use PhpSpec\ObjectBehavior;

final class EmptyCriteriaQueryFactorySpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(EmptyCriteriaQueryFactory::class);
    }

    function it_is_query_factory(): void
    {
        $this->shouldImplement(QueryFactoryInterface::class);
    }

    function it_creates_query(): void
    {
        $this->create()->shouldBeLike(new MatchAllQuery());
    }
}
