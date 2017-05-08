<?php

declare(strict_types = 1);

namespace AppBundle\Event;

final class CartItemRemoved
{
    /**
     * @var string
     */
    private $cartId;

    /**
     * @var string
     */
    private $productCode;

    /**
     * @param string $cartId
     * @param string $productCode
     */
    private function __construct(string $cartId, string $productCode)
    {
        $this->cartId = $cartId;
        $this->productCode = $productCode;
    }

    /**
     * @param string $cartId
     * @param string $productCode
     *
     * @return self
     */
    public static function occur(string $cartId, string $productCode): self
    {
        return new self($cartId, $productCode);
    }

    /**
     * @return string
     */
    public function cartId(): string
    {
        return $this->cartId;
    }

    /**
     * @return string
     */
    public function productCode(): string
    {
        return $this->productCode;
    }

    /**
     * {@inheritdoc}
     */
    public static function deserialize(array $data): self
    {
        return new self(
            $data['cartId'],
            $data['productCode']
        );
    }
}
