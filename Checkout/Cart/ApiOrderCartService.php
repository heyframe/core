<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Cart;

use HeyFrame\Core\Checkout\Cart\Delivery\DeliveryProcessor;
use HeyFrame\Core\Checkout\Cart\Price\Struct\CalculatedPrice;
use HeyFrame\Core\Checkout\Cart\SalesChannel\CartService;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\Context\SalesChannelContextPersister;
use HeyFrame\Core\System\SalesChannel\Context\SalesChannelContextService;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

#[Package('checkout')]
class ApiOrderCartService
{
    /**
     * @internal
     */
    public function __construct(
        protected CartService $cartService,
        protected SalesChannelContextPersister $contextPersister
    ) {
    }

    public function updateShippingCosts(CalculatedPrice $calculatedPrice, SalesChannelContext $context): Cart
    {
        $cart = $this->cartService->getCart($context->getToken(), $context);

        $cart->addExtension(DeliveryProcessor::MANUAL_SHIPPING_COSTS, $calculatedPrice);

        return $this->cartService->recalculate($cart, $context);
    }

    public function addPermission(string $token, string $permission, string $salesChannelId): void
    {
        $payload = $this->contextPersister->load($token, $salesChannelId);

        if (!\array_key_exists(SalesChannelContextService::PERMISSIONS, $payload)) {
            $payload[SalesChannelContextService::PERMISSIONS] = [];
        }

        $payload[SalesChannelContextService::PERMISSIONS][$permission] = true;
        $this->contextPersister->save($token, $payload, $salesChannelId);
    }

    public function deletePermission(string $token, string $permission, string $salesChannelId): void
    {
        $payload = $this->contextPersister->load($token, $salesChannelId);
        $payload[SalesChannelContextService::PERMISSIONS][$permission] = false;

        $this->contextPersister->save($token, $payload, $salesChannelId);
    }
}
