<?php

declare(strict_types=1);

namespace spec\AppBundle\Consumer;

use AppBundle\Consumer\AppConsumer;
use AppBundle\Event\ProductCreated;
use AppBundle\Event\ProductDeleted;
use AppBundle\Event\ProductUpdated;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SimpleBus\Message\Bus\MessageBus;

final class AppConsumerSpec extends ObjectBehavior
{
    function let(MessageBus $eventBus): void
    {
        $this->beConstructedWith($eventBus);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(AppConsumer::class);
    }

    function it_is_amqp_consumer(): void
    {
        $this->shouldImplement(ConsumerInterface::class);
    }

    function it_handles_product_created_event(MessageBus $eventBus): void
    {
        $AMQPmessage = new AMQPMessage('{"type":"ProductCreated","payload":{"id":53,"title":"Witcher","price":{"amount":2299,"currency":{"name":"USD"}}},"recordedOn":"2017-05-07 03:10:26"}');
        $message = json_decode($AMQPmessage->getBody(), true);
        $event = ProductCreated::deserialize($message['payload']);

        $eventBus->handle($event)->shouldBeCalled();

        $this->execute($AMQPmessage);
    }

    function it_handles_product_deleted_event(MessageBus $eventBus): void
    {
        $AMQPmessage = new AMQPMessage('{"type":"ProductDeleted","payload":{"id":53},"recordedOn":"2017-05-07 03:10:26"}');
        $message = json_decode($AMQPmessage->getBody(), true);
        $event = ProductDeleted::deserialize($message['payload']);

        $eventBus->handle($event)->shouldBeCalled();

        $this->execute($AMQPmessage);
    }

    function it_handles_product_updated_event(MessageBus $eventBus): void
    {
        $AMQPmessage = new AMQPMessage('{"type":"ProductUpdated","payload":{"id":53,"title":"Witcher","price":{"amount":2299,"currency":{"name":"USD"}}},"recordedOn":"2017-05-07 03:10:26"}');
        $message = json_decode($AMQPmessage->getBody(), true);
        $event = ProductUpdated::deserialize($message['payload']);

        $eventBus->handle($event)->shouldBeCalled();

        $this->execute($AMQPmessage);
    }

    function it_does_not_handle_unknown_events(MessageBus $eventBus): void
    {
        $eventBus->handle(Argument::any())->shouldNotBeCalled();

        $this->execute(new AMQPMessage('{"type":"ProductCreated","recordedOn":"2017-05-07 03:10:26"}'));
    }

    function it_does_not_handle_events_without_type(MessageBus $eventBus): void
    {
        $eventBus->handle(Argument::any())->shouldNotBeCalled();

        $this->execute(new AMQPMessage('{"payload":{"id":53,"title":"Witcher","price":{"amount":2299,"currency":{"name":"USD"}}},"recordedOn":"2017-05-07 03:10:26"}'));
    }

    function it_does_not_handle_events_without_payload(MessageBus $eventBus): void
    {
        $eventBus->handle(Argument::any())->shouldNotBeCalled();

        $this->execute(new AMQPMessage('{"type":"ProductCreated","recordedOn":"2017-05-07 03:10:26"}'));
    }
}
