<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Cart\SalesChannel;

use HeyFrame\Core\Checkout\Cart\AbstractCartPersister;
use HeyFrame\Core\Checkout\Cart\CartLocker;
use HeyFrame\Core\Checkout\Cart\Event\CartDeletedEvent;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Plugin\Exception\DecorationPatternException;
use HeyFrame\Core\Framework\Routing\StoreApiRouteScope;
use HeyFrame\Core\PlatformRequest;
use HeyFrame\Core\System\SalesChannel\NoContentResponse;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

#[Route(defaults: [PlatformRequest::ATTRIBUTE_ROUTE_SCOPE => [StoreApiRouteScope::ID]])]
#[Package('checkout')]
class CartDeleteRoute extends AbstractCartDeleteRoute
{
    /**
     * @internal
     */
    public function __construct(
        private readonly AbstractCartPersister $cartPersister,
        private readonly EventDispatcherInterface $eventDispatcher,
        private readonly CartLocker $cartLocker
    ) {
    }

    public function getDecorated(): AbstractCartDeleteRoute
    {
        throw new DecorationPatternException(self::class);
    }

    #[Route(path: '/store-api/checkout/cart', name: 'store-api.checkout.cart.delete', methods: ['DELETE'])]
    public function delete(SalesChannelContext $context): NoContentResponse
    {
        return $this->cartLocker->locked($context, function () use ($context) {
            $this->cartPersister->delete($context->getToken(), $context);

            $cartDeleteEvent = new CartDeletedEvent($context);
            $this->eventDispatcher->dispatch($cartDeleteEvent);

            return new NoContentResponse();
        });
    }
}
