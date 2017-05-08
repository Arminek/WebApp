<?php

declare(strict_types=1);

namespace spec\AppBundle\Search\Criteria;

use AppBundle\Search\Criteria\Criteria;
use AppBundle\Search\Criteria\Filtering;
use AppBundle\Search\Criteria\Ordering;
use AppBundle\Search\Criteria\Paginating;
use PhpSpec\ObjectBehavior;

final class CriteriaSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(Criteria::class);
    }

    function it_is_created_from_query_parameters_and_resource_alias(): void
    {
        $this->beConstructedThrough('fromQueryParameters', ['sylius.product', [
            'page' => 2,
            'per_page' => 50,
            'sort' => '-price',
            'option' => 'red',
        ]]);

        $this->className()->shouldReturn('sylius.product');
        $this->filtering()->shouldBeLike(Filtering::fromQueryParameters([
            'page' => 2,
            'per_page' => 50,
            'sort' => '-price',
            'option' => 'red',
        ]));
        $this->paginating()->shouldBeLike(Paginating::fromQueryParameters([
            'page' => 2,
            'per_page' => 50,
            'sort' => '-price',
            'option' => 'red',
        ]));
        $this->ordering()->shouldBeLike(Ordering::fromQueryParameters([
            'page' => 2,
            'per_page' => 50,
            'sort' => '-price',
            'option' => 'red',
        ]));
    }
}
