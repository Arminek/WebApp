<?php

declare(strict_types=1);

namespace spec\AppBundle\Search\Criteria;

use AppBundle\Search\Criteria\Paginating;
use PhpSpec\ObjectBehavior;

final class PaginatingSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(Paginating::class);
    }

    function it_can_be_created_form_query_parameters_with_default_values_if_parameters_are_empty(): void
    {
        $this->beConstructedThrough('fromQueryParameters', [[]]);

        $this->currentPage()->shouldReturn(1);
        $this->itemsPerPage()->shouldReturn(10);
        $this->offset()->shouldReturn(0);
    }

    function it_can_be_created_from_query_parameters_with_default_values_if_parameters_are_not_valid(): void
    {
        $this->beConstructedThrough('fromQueryParameters', [[
            'page' => -1,
            'per_page' => -100,
        ]]);

        $this->currentPage()->shouldReturn(1);
        $this->itemsPerPage()->shouldReturn(10);
        $this->offset()->shouldReturn(0);
    }

    function it_can_be_created_from_query_parameters(): void
    {
        $this->beConstructedThrough('fromQueryParameters', [[
            'page' => 2,
            'per_page' => 50,
        ]]);

        $this->currentPage()->shouldReturn(2);
        $this->itemsPerPage()->shouldReturn(50);
        $this->offset()->shouldReturn(50);
    }
}
