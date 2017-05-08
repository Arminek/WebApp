<?php

declare(strict_types=1);

namespace Tests\AppBundle\Document;

use AppBundle\Document\Price;

final class PriceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_has_amount(): void
    {
        $price = new Price();
        $price->setAmount(1000);

        $this->assertEquals(1000, $price->getAmount());
    }

    /**
     * @test
     */
    public function it_has_currency_code(): void
    {
        $price = new Price();
        $price->setCurrency('USD');

        $this->assertEquals('USD', $price->getCurrency());
    }
}
