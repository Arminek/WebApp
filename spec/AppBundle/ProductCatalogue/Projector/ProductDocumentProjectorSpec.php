<?php

declare(strict_types=1);

namespace spec\AppBundle\Projector;

use AppBundle\Document\Price;
use AppBundle\Document\Product;
use AppBundle\Event\ProductCreated;
use AppBundle\Event\ProductDeleted;
use AppBundle\Event\ProductUpdated;
use AppBundle\Projector\ProductDocumentProjector;
use ONGR\ElasticsearchBundle\Service\Manager;
use PhpSpec\ObjectBehavior;

final class ProductDocumentProjectorSpec extends ObjectBehavior
{
    function let(Manager $manager): void
    {
        $this->beConstructedWith($manager);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(ProductDocumentProjector::class);
    }

    function it_handles_product_created_event(Manager $manager): void
    {
        $event = ProductCreated::deserialize([
            'id' => 1,
            'title' => 'Witcher',
            'price' => ['amount' => 1020, 'currency' => ['name' => 'USD']],
        ]);

        $product = new Product();
        $price = new Price();
        $price->setAmount(1020);
        $price->setCurrency('USD');
        $product->setId(1);
        $product->setTitle('Witcher');
        $product->setPrice($price);

        $manager->persist($product)->shouldBeCalled();
        $manager->commit()->shouldBeCalled();

        $this->handleProductCreated($event);
    }

    function it_handles_product_deleted_event(Manager $manager): void
    {
        $event = ProductDeleted::deserialize(['id' => 1]);

        $product = new Product();

        $manager->find(Product::class, 1)->willReturn($product);
        $manager->remove($product)->shouldBeCalled();

        $this->handleProductDeleted($event);
    }

    function it_handles_product_updated_event(Manager $manager): void
    {
        $event = ProductUpdated::deserialize([
            'id' => 1,
            'title' => 'Fallout',
            'price' => ['amount' => 1020, 'currency' => ['name' => 'USD']],
        ]);

        $product = new Product();
        $price = new Price();
        $price->setAmount(1020);
        $price->setCurrency('USD');
        $product->setId(1);
        $product->setTitle('Witcher');
        $product->setPrice($price);

        $manager->find(Product::class, 1)->willReturn($product);
        $product->setTitle('Fallout');

        $manager->persist($product)->shouldBeCalled();
        $manager->commit()->shouldBeCalled();

        $this->handleProductUpdated($event);
    }
}
