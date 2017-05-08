<?php

declare(strict_types=1);

namespace AppBundle\Model;

final class Cart
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var CartItem[]
     */
    private $items = [];

    /**
     * @var int
     */
    private $total = 0;

    /**
     * @var string
     */
    private $currency;

    /**
     * @param string $id
     * @param CartItem[] $items
     * @param int $total
     * @param string $currency
     */
    private function __construct($id, array $items, $total, $currency)
    {
        $this->id = $id;
        $this->items = $items;
        $this->total = $total;
        $this->currency = $currency;
    }

    /**
     * @param string $id
     * @param string $currency
     * @return Cart
     */
    public static function init(string $id, string $currency): self
    {
        return new self($id, [], 0, $currency);
    }

    /**
     * @param CartItem $cartItem
     */
    public function addItem(CartItem $cartItem): void
    {
        if (isset($this->items[$cartItem->getProductIdentifier()])) {
            $this->changeItemQuantity($cartItem->getProductIdentifier(), $cartItem->getQuantity());

            return;
        }

        $this->items[$cartItem->getProductIdentifier()] = $cartItem;
        $this->total += $cartItem->getSubtotal();
    }

    /**
     * @param string $identifier
     */
    public function removeItem(string $identifier): void
    {
        $this->total -= $this->items[$identifier]->getSubtotal();
        unset($this->items[$identifier]);
    }

    public function clear(): void
    {
        $this->items = [];
        $this->total = 0;
    }

    /**
     * @param string $identifier
     * @param int $quantity
     */
    public function changeItemQuantity(string $identifier, int $quantity): void
    {
        $this->total -= $this->items[$identifier]->getSubtotal();
        $this->items[$identifier]->changeQuantity($quantity);
        $this->total += $this->items[$identifier]->getSubtotal();
    }

    /**
     * @return string
     */
    public function jsonSerialize(): string
    {
        return json_encode(serialize($this));
    }

    /**
     * @param string $cart
     *
     * @return Cart
     */
    public static function jsonDeserialize(string $cart): self
    {
        $cartArray = json_decode($cart, true);

        $items = [];
        foreach ($cartArray['items'] as $item) {
            $items[] = CartItem::deserialize($item);
        }

        return new self(
            $cartArray['id'],
            $items,
            $cartArray['total'],
            $cartArray['currency']
        );
    }
}
