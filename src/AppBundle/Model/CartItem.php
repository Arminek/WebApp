<?php

declare(strict_types=1);

namespace AppBundle\Model;

final class CartItem
{
    /**
     * @var string
     */
    private $productIdentifier;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @var int
     */
    private $unitPrice;

    /**
     * @var string
     */
    private $unitPriceCurrency;

    /**
     * @var int
     */
    private $subtotal;

    /**
     * @param string $productIdentifier
     * @param int $quantity
     * @param int $unitPrice
     * @param string $unitPriceCurrency
     * @param int $subtotal
     */
    public function __construct(
        string $productIdentifier,
        int $quantity,
        int $unitPrice,
        string $unitPriceCurrency,
        int $subtotal
    ) {
        $this->productIdentifier = $productIdentifier;
        $this->quantity = $quantity;
        $this->unitPrice = $unitPrice;
        $this->unitPriceCurrency = $unitPriceCurrency;
        $this->subtotal = $subtotal;
    }

    /**
     * @return string
     */
    public function getProductIdentifier(): string
    {
        return $this->productIdentifier;
    }

    /**
     * @param string $productIdentifier
     */
    public function setProductIdentifier(string $productIdentifier)
    {
        $this->productIdentifier = $productIdentifier;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function changeQuantity(int $quantity)
    {
        $this->quantity = $quantity;
        $this->subtotal = $this->unitPrice * $quantity;
    }

    /**
     * @return int
     */
    public function getUnitPrice(): int
    {
        return $this->unitPrice;
    }

    /**
     * @param int $unitPrice
     */
    public function setUnitPrice(int $unitPrice)
    {
        $this->unitPrice = $unitPrice;
    }

    /**
     * @return string
     */
    public function getUnitPriceCurrency(): string
    {
        return $this->unitPriceCurrency;
    }

    /**
     * @param string $unitPriceCurrency
     */
    public function setUnitPriceCurrency(string $unitPriceCurrency)
    {
        $this->unitPriceCurrency = $unitPriceCurrency;
    }

    /**
     * @return int
     */
    public function getSubtotal(): int
    {
        return $this->subtotal;
    }

    /**
     * @param array $data
     *
     * @return CartItem
     */
    public static function deserialize(array $data): self
    {
        return new self(
            $data['productIdentifier'],
            $data['quantity'],
            $data['unitPrice'],
            $data['unitPriceCurrency'],
            $data['subtotal']
        );
    }
}
