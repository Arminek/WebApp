<?php

declare(strict_types=1);

namespace spec\AppBundle\Search\Elastic\Factory\Sort;

use AppBundle\Search\Criteria\Ordering;
use AppBundle\Search\Elastic\Factory\Sort\SortByFieldQueryFactory;
use AppBundle\Search\Elastic\Factory\Sort\SortFactoryInterface;
use ONGR\ElasticsearchDSL\Sort\FieldSort;
use PhpSpec\ObjectBehavior;

final class SortByFieldQueryFactorySpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(SortByFieldQueryFactory::class);
    }

    function it_is_sort_factory(): void
    {
        $this->shouldImplement(SortFactoryInterface::class);
    }

    function it_creates_descending_field_sort_query(): void
    {
        $ordering = Ordering::fromQueryParameters(['sort' => '-price']);

        $this->create($ordering)->shouldBeLike(new FieldSort('price', 'desc'));
    }

    function it_creates_ascending_field_sort_query(): void
    {
        $ordering = Ordering::fromQueryParameters(['sort' => 'price']);

        $this->create($ordering)->shouldBeLike(new FieldSort('price', 'asc'));
    }

    function it_creates_ascending_by_name_field_sort_query_by_default(): void
    {
        $ordering = Ordering::fromQueryParameters([]);

        $this->create($ordering)->shouldBeLike(new FieldSort('name', 'asc'));
    }
}
