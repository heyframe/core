<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Gateway\Command\Struct;

use HeyFrame\Core\Checkout\Cart\Cart;
use HeyFrame\Core\Checkout\Payment\PaymentMethodCollection;
use HeyFrame\Core\Checkout\Shipping\ShippingMethodCollection;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Struct\Struct;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

#[Package('checkout')]
class CheckoutGatewayPayloadStruct extends Struct
{
    /**
     * @internal
     */
    public function __construct(
        protected Cart $cart,
        protected SalesChannelContext $salesChannelContext,
        protected PaymentMethodCollection $paymentMethods,
        protected ShippingMethodCollection $shippingMethods,
    ) {
    }

    public function getCart(): Cart
    {
        return $this->cart;
    }

    public function getSalesChannelContext(): SalesChannelContext
    {
        return $this->salesChannelContext;
    }

    public function getPaymentMethods(): PaymentMethodCollection
    {
        return $this->paymentMethods;
    }

    public function getShippingMethods(): ShippingMethodCollection
    {
        return $this->shippingMethods;
    }
}
