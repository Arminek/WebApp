<?php

declare(strict_types=1);

namespace AppBundle\Event;

final class CartItemQuantityChanged
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
     * @var int
     */
    private $oldCartItemQuantity;

    /**
     * @var int
     */
    private $newCartItemQuantity;

    /**
     * @param string $cartId
     * @param string $productCode
     * @param int $oldCartItemQuantity
     * @param int $newCartItemQuantity
     */
    private function __construct(
        string $cartId,
        string $productCode,
        int $oldCartItemQuantity,
        int $newCartItemQuantity
    ) {
        $this->cartId = $cartId;
        $this->productCode = $productCode;
        $this->oldCartItemQuantity = $oldCartItemQuantity;
        $this->newCartItemQuantity = $newCartItemQuantity;
    }

    /**
     * @param string $cartId
     * @param string $productCode
     * @param int $oldCartItemQuantity
     * @param int $newCartItemQuantity
     *
     * @return CartItemQuantityChanged
     */
    public static function occur(
        string $cartId,
        string $productCode,
        int $oldCartItemQuantity,
        int $newCartItemQuantity
    ): self {
        return new self($cartId, $productCode, $oldCartItemQuantity, $newCartItemQuantity);
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
     * @return int
     */
    public function oldCartItemQuantity(): int
    {
        return $this->oldCartItemQuantity;
    }

    /**
     * @return int
     */
    public function newCartItemQuantity(): int
    {
        return $this->newCartItemQuantity;
    }

    /**
     * {@inheritdoc}
     */
    public static function deserialize(array $data): self
    {
        return new self(
            $data['cartId'],
            $data['productCode'],
            $data['oldCartItemQuantity'],
            $data['newCartItemQuantity']
        );
    }
}
