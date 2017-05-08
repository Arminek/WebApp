<?php

declare(strict_types=1);

namespace Tests\AppBundle\Event;

use AppBundle\Event\ProductCreated;

final class ProductCreatedTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    function it_is_immutable_fact_of_product_creation(): void
    {
        $event = ProductCreated::deserialize([
            'id' => 1,
            'title' => 'Fallout',
            'price' => ['amount' => 2229, 'currency' => ['name' => 'USD']]
        ]);

        $this->assertEquals(1, $event->id());
        $this->assertEquals('Fallout', $event->title());
        $this->assertEquals(2229, $event->priceAmount());
        $this->assertEquals('USD', $event->priceCurrency());
    }
}
