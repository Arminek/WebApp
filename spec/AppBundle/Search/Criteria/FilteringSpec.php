<?php

declare(strict_types=1);

namespace spec\AppBundle\Search\Criteria;

use AppBundle\Search\Criteria\Filtering;
use PhpSpec\ObjectBehavior;

final class FilteringSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(Filtering::class);
    }

    function it_can_be_created_from_query_parameters(): void
    {
        $this->beConstructedThrough('fromQueryParameters', [[
            'option' => 'red',
            'size' => 's',
        ]]);

        $this->fields()->shouldReturn(['option' => 'red', 'size' => 's',]);
    }

    function it_removes_page_per_page_and_sort_attributes_from_query_parameters(): void
    {
        $this->beConstructedThrough('fromQueryParameters', [[
            'option' => 'blue',
            'size' => 'm',
            'sort' => 'name',
            'page' => 10,
            'per_page' => 50,
        ]]);

        $this->fields()->shouldReturn(['option' => 'blue', 'size' => 'm',]);
    }
}
