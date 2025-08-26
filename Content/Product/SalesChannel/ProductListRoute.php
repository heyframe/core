<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Product\SalesChannel;

use HeyFrame\Core\Content\Product\ProductCollection;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Criteria;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Plugin\Exception\DecorationPatternException;
use HeyFrame\Core\Framework\Routing\StoreApiRouteScope;
use HeyFrame\Core\PlatformRequest;
use HeyFrame\Core\System\SalesChannel\Entity\SalesChannelRepository;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\Routing\Attribute\Route;

#[Route(defaults: [PlatformRequest::ATTRIBUTE_ROUTE_SCOPE => [StoreApiRouteScope::ID]])]
#[Package('inventory')]
class ProductListRoute extends AbstractProductListRoute
{
    /**
     * @internal
     *
     * @param SalesChannelRepository<ProductCollection> $productRepository
     */
    public function __construct(private readonly SalesChannelRepository $productRepository)
    {
    }

    public function getDecorated(): AbstractProductListRoute
    {
        throw new DecorationPatternException(self::class);
    }

    #[Route(path: '/store-api/product', name: 'store-api.product.search', methods: ['GET', 'POST'], defaults: ['_entity' => 'product'])]
    public function load(Criteria $criteria, SalesChannelContext $context): ProductListResponse
    {
        return new ProductListResponse($this->productRepository->search($criteria, $context));
    }
}
