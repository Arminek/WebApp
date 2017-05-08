<?php

declare(strict_types=1);

namespace AppBundle\Event;

final class ProductUpdated
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var int
     */
    private $priceAmount;

    /**
     * @var string
     */
    private $priceCurrency;

    /**
     * @param int $id
     * @param string $title
     * @param int $priceAmount
     * @param string $priceCurrency
     */
    private function __construct(int $id, string $title, int $priceAmount, string $priceCurrency)
    {
        $this->id = $id;
        $this->title = $title;
        $this->priceAmount = $priceAmount;
        $this->priceCurrency = $priceCurrency;
    }

    /**
     * @param array $data
     *
     * @return ProductUpdated
     */
    public static function deserialize(array $data): self
    {
        return new self($data['id'], $data['title'], $data['price']['amount'], $data['price']['currency']['name']);
    }

    /**
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * @return int
     */
    public function priceAmount(): int
    {
        return $this->priceAmount;
    }

    /**
     * @return string
     */
    public function priceCurrency(): string
    {
        return $this->priceCurrency;
    }
}
