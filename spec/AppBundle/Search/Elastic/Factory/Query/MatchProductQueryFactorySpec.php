<?php

declare(strict_types=1);

namespace spec\AppBundle\Search\Elastic\Factory\Query;

use AppBundle\Exception\MissingQueryParameterException;
use AppBundle\Search\Elastic\Factory\Query\MatchProductQueryFactory;
use AppBundle\Search\Elastic\Factory\Query\QueryFactoryInterface;
use ONGR\ElasticsearchDSL\Query\FullText\MatchQuery;
use PhpSpec\ObjectBehavior;

final class MatchProductQueryFactorySpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(MatchProductQueryFactory::class);
    }

    function it_is_query_factory(): void
    {
        $this->shouldImplement(QueryFactoryInterface::class);
    }

    function it_creates_match_query_with_name_field_by_default(): void
    {
        $this->create(['search' => 'banana'])->shouldBeLike(new MatchQuery('title', 'banana'));
    }

    function it_cannot_be_created_without_search_parameter(): void
    {
        $this->shouldThrow(MissingQueryParameterException::class)->during('create', []);
    }

    function it_cannot_be_created_with_search_parameter(): void
    {
        $this->shouldThrow(MissingQueryParameterException::class)->during('create', [[]]);
    }

    function it_cannot_be_created_with_empty_search_parameter(): void
    {
        $this->shouldThrow(MissingQueryParameterException::class)->during('create', [['search' => null]]);
    }

    function it_cannot_be_created_with_empty_string_search_parameter(): void
    {
        $this->shouldThrow(MissingQueryParameterException::class)->during('create', [['search' => '']]);
    }
}
