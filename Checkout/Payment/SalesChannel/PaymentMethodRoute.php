<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Payment\SalesChannel;

use HeyFrame\Core\Checkout\Payment\Hook\PaymentMethodRouteHook;
use HeyFrame\Core\Checkout\Payment\PaymentMethodCollection;
use HeyFrame\Core\Framework\Adapter\Cache\CacheTagCollector;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Criteria;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Sorting\FieldSorting;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Plugin\Exception\DecorationPatternException;
use HeyFrame\Core\Framework\Routing\StoreApiRouteScope;
use HeyFrame\Core\Framework\Rule\RuleIdMatcher;
use HeyFrame\Core\Framework\Script\Execution\ScriptExecutor;
use HeyFrame\Core\PlatformRequest;
use HeyFrame\Core\System\SalesChannel\Entity\SalesChannelRepository;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route(defaults: [PlatformRequest::ATTRIBUTE_ROUTE_SCOPE => [StoreApiRouteScope::ID]])]
#[Package('checkout')]
class PaymentMethodRoute extends AbstractPaymentMethodRoute
{
    final public const ALL_TAG = 'payment-method-route';

    /**
     * @internal
     *
     * @param SalesChannelRepository<PaymentMethodCollection> $paymentMethodRepository
     */
    public function __construct(
        private readonly SalesChannelRepository $paymentMethodRepository,
        private readonly CacheTagCollector $cacheTagCollector,
        private readonly ScriptExecutor $scriptExecutor,
        private readonly RuleIdMatcher $ruleIdMatcher,
    ) {
    }

    public function getDecorated(): AbstractPaymentMethodRoute
    {
        throw new DecorationPatternException(self::class);
    }

    public static function buildName(string $salesChannelId): string
    {
        return 'payment-method-route-' . $salesChannelId;
    }

    #[Route(
        path: '/store-api/payment-method',
        name: 'store-api.payment.method',
        defaults: ['_entity' => 'payment_method'],
        methods: ['GET', 'POST']
    )]
    public function load(Request $request, SalesChannelContext $context, Criteria $criteria): PaymentMethodRouteResponse
    {
        $this->cacheTagCollector->addTag(self::buildName($context->getSalesChannelId()));

        $criteria
            ->addFilter(new EqualsFilter('active', true))
            ->addSorting(new FieldSorting('position'))
            ->addAssociation('media');

        $result = $this->paymentMethodRepository->search($criteria, $context);

        $paymentMethods = $result->getEntities();
        $paymentMethods->sortPaymentMethodsByPreference($context);

        if ($request->query->getBoolean('onlyAvailable') || $request->request->getBoolean('onlyAvailable')) {
            $paymentMethods = $this->ruleIdMatcher->filterCollection($paymentMethods, $context->getRuleIds());
        }

        $result->assign(['entities' => $paymentMethods, 'elements' => $paymentMethods->getElements(), 'total' => $paymentMethods->count()]);

        $this->scriptExecutor->execute(new PaymentMethodRouteHook(
            $paymentMethods,
            $request->query->getBoolean('onlyAvailable') || $request->request->getBoolean('onlyAvailable'),
            $context,
        ));

        return new PaymentMethodRouteResponse($result);
    }
}
