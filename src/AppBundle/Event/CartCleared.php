<?php

declare(strict_types = 1);

namespace AppBundle\Event;

final class CartCleared
{
    /**
     * @var string
     */
    private $cartId;

    /**
     * @param string $cartId
     */
    private function __construct(string $cartId)
    {
        $this->cartId = $cartId;
    }

    /**
     * @param string $cartId
     *
     * @return CartCleared
     */
    public static function occur(string $cartId): self
    {
        return new self($cartId);
    }

    /**
     * @return string
     */
    public function cartId(): string
    {
        return $this->cartId;
    }

    /**
     * {@inheritdoc}
     */
    public static function deserialize(array $data)
    {
        return new self(
            $data['cartId']
        );
    }
}
