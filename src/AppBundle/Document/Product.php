<?php

declare(strict_types=1);

namespace AppBundle\Document;

use ONGR\ElasticsearchBundle\Annotation as ElasticSearch;

/**
 * @ElasticSearch\Document(type="product")
 */
final class Product
{
    /**
     * @var int
     *
     * @ElasticSearch\Id()
     */
    private $id;

    /**
     * @var string
     *
     * @ElasticSearch\Property(type="keyword")
     */
    private $title;

    /**
     * @var Price
     *
     * @ElasticSearch\Embedded(class="AppBundle:Price")
     */
    private $price;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return Price
     */
    public function getPrice(): Price
    {
        return $this->price;
    }

    /**
     * @param Price $price
     */
    public function setPrice(Price $price): void
    {
        $this->price = $price;
    }
}
