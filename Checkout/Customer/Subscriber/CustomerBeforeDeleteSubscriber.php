<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Customer\Subscriber;

use HeyFrame\Core\Checkout\Customer\CustomerCollection;
use HeyFrame\Core\Checkout\Customer\CustomerDefinition;
use HeyFrame\Core\Checkout\Customer\Event\CustomerDeletedEvent;
use HeyFrame\Core\Framework\Api\Context\SalesChannelApiSource;
use HeyFrame\Core\Framework\Api\Serializer\JsonEntityEncoder;
use HeyFrame\Core\Framework\DataAbstractionLayer\EntityRepository;
use HeyFrame\Core\Framework\DataAbstractionLayer\Event\EntityDeleteEvent;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Criteria;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Util\Random;
use HeyFrame\Core\System\SalesChannel\Context\SalesChannelContextServiceInterface;
use HeyFrame\Core\System\SalesChannel\Context\SalesChannelContextServiceParameters;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @internal
 */
#[Package('checkout')]
class CustomerBeforeDeleteSubscriber implements EventSubscriberInterface
{
    /**
     * @param EntityRepository<CustomerCollection> $customerRepository
     *
     * @internal
     */
    public function __construct(
        private readonly EntityRepository $customerRepository,
        private readonly SalesChannelContextServiceInterface $salesChannelContextService,
        private readonly EventDispatcherInterface $eventDispatcher,
        private readonly JsonEntityEncoder $jsonEntityEncoder
    ) {
    }

    /**
     * @return array<string, string>
     */
    public static function getSubscribedEvents(): array
    {
        return [
            EntityDeleteEvent::class => 'beforeDelete',
        ];
    }

    public function beforeDelete(EntityDeleteEvent $event): void
    {
        $context = $event->getContext();

        $ids = $event->getIds(CustomerDefinition::ENTITY_NAME);

        if (empty($ids)) {
            return;
        }

        $source = $context->getSource();
        $salesChannelId = null;

        if ($source instanceof SalesChannelApiSource) {
            $salesChannelId = $source->getSalesChannelId();
        }

        $criteria = (new Criteria($ids))
            ->addAssociations([
                'salutation',
                'defaultBillingAddress.country',
                'defaultBillingAddress.countryState',
                'defaultBillingAddress.salutation',
                'defaultShippingAddress.country',
                'defaultShippingAddress.countryState',
                'defaultShippingAddress.salutation',
            ]);

        $customers = $this->customerRepository->search($criteria, $context)->getEntities();

        $event->addSuccess(function () use ($customers, $context, $salesChannelId, $criteria): void {
            foreach ($customers as $customer) {
                $salesChannelContext = $this->salesChannelContextService->get(
                    new SalesChannelContextServiceParameters(
                        $salesChannelId ?? $customer->getSalesChannelId(),
                        Random::getAlphanumericString(32),
                        $customer->getLanguageId(),
                        null,
                        null,
                        $context,
                    )
                );

                $this->eventDispatcher->dispatch(new CustomerDeletedEvent(
                    $salesChannelContext,
                    $customer,
                    $this->jsonEntityEncoder->encode(
                        $criteria,
                        $this->customerRepository->getDefinition(),
                        $customer,
                        '/api/customer'
                    )
                ));
            }
        });
    }
}
