<?php

declare(strict_types = 1);

namespace AppBundle\Event;

final class CartPickedUp
{
    /**
     * @var string
     */
    private $cartId;

    /**
     * @var string
     */
    private $cartCurrency;

    /**
     * @param string $cartId
     * @param string $cartCurrency
     */
    private function __construct(string $cartId, string $cartCurrency)
    {
        $this->cartId = $cartId;
        $this->cartCurrency = $cartCurrency;
    }

    /**
     * @param string $cartId
     * @param string $cartCurrency
     *
     * @return self
     */
    public static function occur(string $cartId, string $cartCurrency): self
    {
        return new self($cartId, $cartCurrency);
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
    public function cartCurrency(): string
    {
        return $this->cartCurrency;
    }

    /**
     * {@inheritdoc}
     */
    public static function deserialize(array $data)
    {
        return new self(
            $data['cartId'],
            $data['cartCurrency']
        );
    }
}
