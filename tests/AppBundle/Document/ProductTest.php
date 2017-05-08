<?php

declare(strict_types=1);

namespace Tests\AppBundle\Document;

use AppBundle\Document\Price;
use AppBundle\Document\Product;

final class ProductTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_has_identifier(): void
    {
        $product = new Product();
        $product->setId(1);

        $this->assertEquals(1, $product->getId());
    }

    /**
     * @test
     */
    public function it_has_title(): void
    {
        $product = new Product();
        $product->setTitle('Fallout');

        $this->assertEquals('Fallout', $product->getTitle());
    }

    /**
     * @test
     */
    public function it_has_price(): void
    {
        $product = new Product();
        $price = new Price();

        $product->setPrice($price);

        $this->assertEquals($price, $product->getPrice());
    }
}
