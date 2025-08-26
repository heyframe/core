<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Seo\SalesChannel;

use HeyFrame\Core\Content\Seo\SeoUrl\SeoUrlCollection;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Criteria;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Plugin\Exception\DecorationPatternException;
use HeyFrame\Core\Framework\Routing\StoreApiRouteScope;
use HeyFrame\Core\PlatformRequest;
use HeyFrame\Core\System\SalesChannel\Entity\SalesChannelRepository;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route(defaults: [PlatformRequest::ATTRIBUTE_ROUTE_SCOPE => [StoreApiRouteScope::ID]])]
#[Package('inventory')]
class SeoUrlRoute extends AbstractSeoUrlRoute
{
    /**
     * @internal
     *
     * @param SalesChannelRepository<SeoUrlCollection> $salesChannelRepository
     */
    public function __construct(private readonly SalesChannelRepository $salesChannelRepository)
    {
    }

    public function getDecorated(): AbstractSeoUrlRoute
    {
        throw new DecorationPatternException(self::class);
    }

    #[Route(path: '/store-api/seo-url', name: 'store-api.seo.url', methods: ['GET', 'POST'], defaults: ['_entity' => 'seo_url'])]
    public function load(Request $request, SalesChannelContext $context, Criteria $criteria): SeoUrlRouteResponse
    {
        return new SeoUrlRouteResponse($this->salesChannelRepository->search($criteria, $context));
    }
}
