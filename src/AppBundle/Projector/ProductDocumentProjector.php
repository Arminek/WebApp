<?php

declare(strict_types=1);

namespace AppBundle\Projector;

use AppBundle\Document\Price;
use AppBundle\Document\Product;
use AppBundle\Event\ProductCreated;
use AppBundle\Event\ProductDeleted;
use AppBundle\Event\ProductUpdated;
use ONGR\ElasticsearchBundle\Service\Manager;

final class ProductDocumentProjector
{
    /**
     * @var Manager
     */
    private $manager;

    /**
     * @param Manager $manager
     */
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param ProductCreated $event
     */
    public function handleProductCreated(ProductCreated $event): void
    {
        $price = new Price();
        $price->setAmount($event->priceAmount());
        $price->setCurrency($event->priceCurrency());

        $product = new Product();
        $product->setTitle($event->title());
        $product->setId($event->id());
        $product->setPrice($price);

        $this->manager->persist($product);
        $this->manager->commit();
    }

    /**
     * @param ProductUpdated $event
     */
    public function handleProductUpdated(ProductUpdated $event): void
    {
        $price = new Price();
        $price->setAmount($event->priceAmount());
        $price->setCurrency($event->priceCurrency());

        /** @var Product $product */
        $product = $this->manager->find(Product::class, $event->id());

        $product->setPrice($price);
        $product->setTitle($event->title());

        $this->manager->persist($product);
        $this->manager->commit();
    }

    /**
     * @param ProductDeleted $event
     */
    public function handleProductDeleted(ProductDeleted $event): void
    {
        /** @var Product $product */
        $product = $this->manager->find(Product::class, $event->id());

        $this->manager->remove($product);
    }
}
