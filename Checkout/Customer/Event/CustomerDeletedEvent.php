<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Customer\Event;

use HeyFrame\Core\Checkout\Customer\CustomerDefinition;
use HeyFrame\Core\Checkout\Customer\CustomerEntity;
use HeyFrame\Core\Content\Flow\Dispatching\Aware\ScalarValuesAware;
use HeyFrame\Core\Framework\Context;
use HeyFrame\Core\Framework\Event\CustomerAware;
use HeyFrame\Core\Framework\Event\EventData\EntityType;
use HeyFrame\Core\Framework\Event\EventData\EventDataCollection;
use HeyFrame\Core\Framework\Event\EventData\MailRecipientStruct;
use HeyFrame\Core\Framework\Event\FlowEventAware;
use HeyFrame\Core\Framework\Event\MailAware;
use HeyFrame\Core\Framework\Event\HeyFrameSalesChannelEvent;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Contracts\EventDispatcher\Event;

#[Package('checkout')]
class CustomerDeletedEvent extends Event implements HeyFrameSalesChannelEvent, CustomerAware, MailAware, ScalarValuesAware, FlowEventAware
{
    final public const EVENT_NAME = 'checkout.customer.deleted';

    private ?MailRecipientStruct $mailRecipientStruct = null;

    /**
     * @param array<string, mixed> $serializedCustomer
     */
    public function __construct(
        private readonly SalesChannelContext $salesChannelContext,
        private readonly CustomerEntity $customer,
        private readonly array $serializedCustomer = []
    ) {
    }

    public function getName(): string
    {
        return self::EVENT_NAME;
    }

    public function getCustomerId(): string
    {
        return $this->customer->getId();
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

    public function getSalesChannelId(): ?string
    {
        return $this->salesChannelContext->getSalesChannelId();
    }

    public function getMailStruct(): MailRecipientStruct
    {
        if (!$this->mailRecipientStruct instanceof MailRecipientStruct) {
            $this->mailRecipientStruct = new MailRecipientStruct([
                $this->customer->getEmail() => $this->customer->getFirstName() . ' ' . $this->customer->getLastName(),
            ]);
        }

        return $this->mailRecipientStruct;
    }

    public static function getAvailableData(): EventDataCollection
    {
        return (new EventDataCollection())
            ->add('customer', new EntityType(CustomerDefinition::class));
    }

    public function getValues(): array
    {
        return [
            'customer' => $this->serializedCustomer,
        ];
    }
}
