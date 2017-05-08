<?php

declare(strict_types=1);

namespace Tests\AppBundle\Event;

use AppBundle\Event\ProductUpdated;

final class ProductUpdatedTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    function it_is_immutable_fact_of_product_update(): void
    {
        $event = ProductUpdated::deserialize([
            'id' => 1,
            'title' => 'Witcher',
            'price' => ['amount' => 3099, 'currency' => ['name' => 'USD']],
        ]);

        $this->assertEquals(1, $event->id());
        $this->assertEquals('Witcher', $event->title());
        $this->assertEquals(3099, $event->priceAmount());
        $this->assertEquals('USD', $event->priceCurrency());
    }
}
