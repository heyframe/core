<?php declare(strict_types=1);

namespace HeyFrame\Core\System\Currency\SalesChannel;

use HeyFrame\Core\Framework\Adapter\Cache\CacheTagCollector;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Criteria;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Plugin\Exception\DecorationPatternException;
use HeyFrame\Core\Framework\Routing\StoreApiRouteScope;
use HeyFrame\Core\PlatformRequest;
use HeyFrame\Core\System\Currency\CurrencyCollection;
use HeyFrame\Core\System\SalesChannel\Entity\SalesChannelRepository;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route(defaults: [PlatformRequest::ATTRIBUTE_ROUTE_SCOPE => [StoreApiRouteScope::ID]])]
#[Package('fundamentals@framework')]
class CurrencyRoute extends AbstractCurrencyRoute
{
    final public const ALL_TAG = 'currency-route';

    /**
     * @internal
     *
     * @param SalesChannelRepository<CurrencyCollection> $currencyRepository
     */
    public function __construct(
        private readonly SalesChannelRepository $currencyRepository,
        private readonly CacheTagCollector $cacheTagCollector,
    ) {
    }

    public function getDecorated(): AbstractCurrencyRoute
    {
        throw new DecorationPatternException(self::class);
    }

    public static function buildName(string $salesChannelId): string
    {
        return 'currency-route-' . $salesChannelId;
    }

    #[Route(path: '/store-api/currency', name: 'store-api.currency', methods: ['GET', 'POST'], defaults: ['_entity' => 'currency'])]
    public function load(Request $request, SalesChannelContext $context, Criteria $criteria): CurrencyRouteResponse
    {
        $this->cacheTagCollector->addTag(self::buildName($context->getSalesChannelId()), self::ALL_TAG);

        return new CurrencyRouteResponse($this->currencyRepository->search($criteria, $context)->getEntities());
    }
}
