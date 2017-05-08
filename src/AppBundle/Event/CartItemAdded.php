<?php

declare(strict_types = 1);

namespace AppBundle\Event;

final class CartItemAdded
{
    /**
     * @var string
     */
    private $cartId;

    /**
     * @var array
     */
    private $cartItem;

    /**
     * @param string $cartId
     * @param array $cartItem
     */
    private function __construct(string $cartId, array $cartItem)
    {
        $this->cartId = $cartId;
        $this->cartItem = $cartItem;
    }

    /**
     * @param string $cartId
     * @param array $cartItem
     *
     * @return CartItemAdded
     */
    public static function occur(string $cartId, array $cartItem): self
    {
        return new self($cartId, $cartItem);
    }

    /**
     * @return string
     */
    public function cartId(): string
    {
        return $this->cartId;
    }

    /**
     * @return array
     */
    public function cartItem(): array
    {
        return $this->cartItem;
    }

    /**
     * {@inheritdoc}
     */
    public static function deserialize(array $data)
    {
        return new self(
            $data['cartId'],
            $data['cartItem']
        );
    }
}
