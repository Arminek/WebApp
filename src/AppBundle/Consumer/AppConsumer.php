<?php

declare(strict_types=1);

namespace AppBundle\Consumer;

use AppBundle\Event\CartCleared;
use AppBundle\Event\CartItemAdded;
use AppBundle\Event\CartItemQuantityChanged;
use AppBundle\Event\CartItemRemoved;
use AppBundle\Event\CartPickedUp;
use AppBundle\Event\ProductCreated;
use AppBundle\Event\ProductDeleted;
use AppBundle\Event\ProductUpdated;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use SimpleBus\Message\Bus\MessageBus;

final class AppConsumer implements ConsumerInterface
{
    const CART_CLEARED_MESSAGE_TYPE = 'CartCleared';
    const CART_ITEM_ADDED_MESSAGE_TYPE = 'CartItemAdded';
    const CART_ITEM_QUANTITY_CHANGED_MESSAGE_TYPE = 'CartItemQuantityChanged';
    const CART_ITEM_REMOVED_MESSAGE_TYPE = 'CartItemRemoved';
    const CART_PICKED_UP_MESSAGE_TYPE = 'CartPickedUp';
    const PRODUCT_CREATED_MESSAGE_TYPE = 'ProductCreated';
    const PRODUCT_UPDATED_MESSAGE_TYPE = 'ProductUpdated';
    const PRODUCT_DELETED_MESSAGE_TYPE = 'ProductDeleted';

    /**
     * @var MessageBus
     */
    private $eventBus;

    /**
     * @var array
     */
    private $eventConfiguration;

    /**
     * @param MessageBus $eventBus
     */
    public function __construct(MessageBus $eventBus)
    {
        $this->eventBus = $eventBus;
        $this->eventConfiguration = [
            self::CART_CLEARED_MESSAGE_TYPE => CartCleared::class,
            self::CART_ITEM_ADDED_MESSAGE_TYPE => CartItemAdded::class,
            self::CART_ITEM_QUANTITY_CHANGED_MESSAGE_TYPE => CartItemQuantityChanged::class,
            self::CART_ITEM_REMOVED_MESSAGE_TYPE => CartItemRemoved::class,
            self::CART_PICKED_UP_MESSAGE_TYPE => CartPickedUp::class,
            self::PRODUCT_CREATED_MESSAGE_TYPE => ProductCreated::class,
            self::PRODUCT_UPDATED_MESSAGE_TYPE => ProductUpdated::class,
            self::PRODUCT_DELETED_MESSAGE_TYPE => ProductDeleted::class,
        ];
    }

    /**
     * @param AMQPMessage $message
     */
    public function execute(AMQPMessage $message): void
    {
        $message = json_decode($message->getBody(), true);

        if (
            isset($message['type']) &&
            array_key_exists($message['type'], $this->eventConfiguration) &&
            isset($message['payload'])
        ) {
            $this->eventBus->handle($this->eventConfiguration[$message['type']]::deserialize($message['payload']));
        }
    }
}
