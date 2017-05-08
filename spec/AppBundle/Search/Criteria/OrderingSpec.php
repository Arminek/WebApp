<?php

declare(strict_types=1);

namespace spec\AppBundle\Search\Criteria;

use AppBundle\Search\Criteria\Ordering;
use PhpSpec\ObjectBehavior;

final class OrderingSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(Ordering::class);
    }

    function it_can_be_created_from_query_parameters_with_default_direction(): void
    {
        $this->beConstructedThrough('fromQueryParameters', [[
            'sort' => 'code',
        ]]);

        $this->field()->shouldReturn('code');
        $this->direction()->shouldReturn('asc');
    }

    function it_can_be_created_from_query_parameters(): void
    {
        $this->beConstructedThrough('fromQueryParameters', [[
            'sort' => '-code',
        ]]);

        $this->field()->shouldReturn('code');
        $this->direction()->shouldReturn('desc');
    }
}
