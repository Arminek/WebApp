<?php

declare(strict_types=1);

namespace AppBundle\Projector;

use AppBundle\Event\CartCleared;
use AppBundle\Event\CartItemAdded;
use AppBundle\Event\CartItemQuantityChanged;
use AppBundle\Event\CartItemRemoved;
use AppBundle\Event\CartPickedUp;
use AppBundle\Model\Cart;
use AppBundle\Model\CartItem;
use Predis\ClientInterface;

final class CartRedisProjector
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param CartCleared $event
     */
    public function handleCartCleared(CartCleared $event): void
    {
        /** @var Cart $cart */
        $cart = Cart::jsonDeserialize($this->client->get($event->cartId()));
        $cart->clear();

        $this->client->set($event->cartId(), $cart->jsonSerialize());
    }

    /**
     * @param CartItemAdded $event
     */
    public function handleCartItemAdded(CartItemAdded $event): void
    {
        /** @var Cart $cart */
        $cart = Cart::jsonDeserialize($this->client->get($event->cartId()));
        $cartItem = new CartItem(
            $event->cartItem()['productCode'],
            (int) $event->cartItem()['quantity'],
            (int) $event->cartItem()['unitPrice']['amount'],
            $event->cartItem()['unitPrice']['currency'],
            (int) $event->cartItem()['quantity'] * (int) $event->cartItem()['unitPrice']['amount']
        );
        $cart->addItem($cartItem);

        $this->client->set($event->cartId(), $cart);
    }

    /**
     * @param CartItemQuantityChanged $event
     */
    public function handleCartItemQuantityChanged(CartItemQuantityChanged $event): void
    {
        /** @var Cart $cart */
        $cart = Cart::jsonDeserialize($this->client->get($event->cartId()));

        $cart->changeItemQuantity($event->productCode(), $event->newCartItemQuantity());

        $this->client->set($event->cartId(), $cart->jsonSerialize());
    }

    /**
     * @param CartItemRemoved $event
     */
    public function handleCartItemRemoved(CartItemRemoved $event): void
    {
        /** @var Cart $cart */
        $cart = Cart::jsonDeserialize($this->client->get($event->cartId()));

        $cart->removeItem($event->productCode());

        $this->client->set($event->cartId(), $cart->jsonSerialize());
    }

    /**
     * @param CartPickedUp $event
     */
    public function handleCartPickedUp(CartPickedUp $event): void
    {
        $cart = Cart::init($event->cartId(), $event->cartCurrency());

        $this->client->set($event->cartId(), $cart->jsonSerialize());
    }
}
