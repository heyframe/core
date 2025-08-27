<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Customer\Event;

use HeyFrame\Core\Checkout\Customer\CustomerDefinition;
use HeyFrame\Core\Checkout\Customer\CustomerEntity;
use HeyFrame\Core\Framework\Context;
use HeyFrame\Core\Framework\Event\EventData\EntityType;
use HeyFrame\Core\Framework\Event\EventData\EventDataCollection;
use HeyFrame\Core\Framework\Event\EventData\ScalarValueType;
use HeyFrame\Core\Framework\Event\FlowEventAware;
use HeyFrame\Core\Framework\Event\HeyFrameSalesChannelEvent;
use HeyFrame\Core\Framework\Event\SalesChannelAware;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Contracts\EventDispatcher\Event;

#[Package('checkout')]
class CustomerSetDefaultBillingAddressEvent extends Event implements SalesChannelAware, HeyFrameSalesChannelEvent, FlowEventAware
{
    final public const EVENT_NAME = 'checkout.customer.default.billing.address.event';

    public function __construct(
        private readonly SalesChannelContext $salesChannelContext,
        private readonly CustomerEntity $customer,
        private string $addressId
    ) {
    }

    public function getName(): string
    {
        return self::EVENT_NAME;
    }

    public function getCustomer(): CustomerEntity
    {
        return $this->customer;
    }

    public function getSalesChannelContext(): SalesChannelContext
    {
        return $this->salesChannelContext;
    }

    public function getContext(): Context
    {
        return $this->salesChannelContext->getContext();
    }

    public function getSalesChannelId(): string
    {
        return $this->salesChannelContext->getSalesChannelId();
    }

    public static function getAvailableData(): EventDataCollection
    {
        return (new EventDataCollection())
            ->add('customer', new EntityType(CustomerDefinition::class))
            ->add('contextToken', new ScalarValueType(ScalarValueType::TYPE_STRING));
    }

    public function getAddressId(): string
    {
        return $this->addressId;
    }

    public function setAddressId(string $addressId): void
    {
        $this->addressId = $addressId;
    }
}
