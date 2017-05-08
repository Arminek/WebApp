<?php

declare(strict_types=1);

namespace Tests\AppBundle\Event;

use AppBundle\Event\ProductDeleted;

final class ProductDeletedTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    function it_is_immutable_fact_of_product_deletion(): void
    {
        $event = ProductDeleted::deserialize([
            'id' => 1,
        ]);

        $this->assertEquals(1, $event->id());
    }
}
