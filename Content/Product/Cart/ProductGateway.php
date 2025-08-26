<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Product\Cart;

use HeyFrame\Core\Content\Product\Events\ProductGatewayCriteriaEvent;
use HeyFrame\Core\Content\Product\ProductCollection;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Criteria;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\Entity\SalesChannelRepository;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

#[Package('inventory')]
class ProductGateway implements ProductGatewayInterface
{
    /**
     * @internal
     *
     * @param SalesChannelRepository<ProductCollection> $repository
     */
    public function __construct(
        private readonly SalesChannelRepository $repository,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    /**
     * @param list<string> $ids
     */
    public function get(array $ids, SalesChannelContext $context): ProductCollection
    {
        $criteria = new Criteria($ids);
        $criteria->setTitle('cart::products');
        $criteria->addAssociation('cover.media');
        $criteria->addAssociation('options.group');
        $criteria->addAssociation('featureSet');
        $criteria->addAssociation('properties.group');

        $this->eventDispatcher->dispatch(
            new ProductGatewayCriteriaEvent($ids, $criteria, $context)
        );

        return $this->repository->search($criteria, $context)->getEntities();
    }
}
