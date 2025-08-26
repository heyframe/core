<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Cart\Event;

use HeyFrame\Core\Checkout\Cart\CartException;
use HeyFrame\Core\Checkout\Order\OrderDefinition;
use HeyFrame\Core\Checkout\Order\OrderEntity;
use HeyFrame\Core\Framework\Context;
use HeyFrame\Core\Framework\Event\CustomerAware;
use HeyFrame\Core\Framework\Event\CustomerGroupAware;
use HeyFrame\Core\Framework\Event\EventData\EntityType;
use HeyFrame\Core\Framework\Event\EventData\EventDataCollection;
use HeyFrame\Core\Framework\Event\EventData\MailRecipientStruct;
use HeyFrame\Core\Framework\Event\FlowEventAware;
use HeyFrame\Core\Framework\Event\MailAware;
use HeyFrame\Core\Framework\Event\OrderAware;
use HeyFrame\Core\Framework\Event\SalesChannelAware;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Script\Execution\Awareness\SalesChannelContextAware;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Contracts\EventDispatcher\Event;

#[Package('checkout')]
class CheckoutOrderPlacedEvent extends Event implements SalesChannelAware, SalesChannelContextAware, OrderAware, MailAware, CustomerAware, CustomerGroupAware, FlowEventAware
{
    final public const EVENT_NAME = 'checkout.order.placed';

    public function __construct(
        private readonly SalesChannelContext $context,
        private readonly OrderEntity $order,
        private ?MailRecipientStruct $mailRecipientStruct = null
    ) {
    }

    public function getName(): string
    {
        return self::EVENT_NAME;
    }

    public function getOrder(): OrderEntity
    {
        return $this->order;
    }

    public function getOrderId(): string
    {
        return $this->order->getId();
    }

    public static function getAvailableData(): EventDataCollection
    {
        return (new EventDataCollection())
            ->add('order', new EntityType(OrderDefinition::class));
    }

    public function getContext(): Context
    {
        return $this->context->getContext();
    }

    public function getSalesChannelContext(): SalesChannelContext
    {
        return $this->context;
    }

    public function getMailStruct(): MailRecipientStruct
    {
        if (!$this->mailRecipientStruct instanceof MailRecipientStruct) {
            $this->mailRecipientStruct = new MailRecipientStruct([
                $this->order->getOrderCustomer()?->getEmail() => $this->order->getOrderCustomer()?->getFirstName() . ' ' . $this->order->getOrderCustomer()?->getLastName(),
            ]);
        }

        return $this->mailRecipientStruct;
    }

    public function getSalesChannelId(): string
    {
        return $this->context->getSalesChannelId();
    }

    public function getCustomerId(): string
    {
        $customerId = $this->order->getOrderCustomer()?->getCustomerId();

        if (!$customerId) {
            throw CartException::orderCustomerDeleted($this->order->getId());
        }

        return $customerId;
    }

    public function getCustomerGroupId(): string
    {
        return $this->context->getCustomerGroupId();
    }
}
