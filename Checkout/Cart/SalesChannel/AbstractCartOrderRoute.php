<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Cart\SalesChannel;

use HeyFrame\Core\Checkout\Cart\Cart;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Validation\DataBag\RequestDataBag;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

/**
 * This route can be used to create an order from the cart
 */
#[Package('checkout')]
abstract class AbstractCartOrderRoute
{
    abstract public function getDecorated(): AbstractCartOrderRoute;

    abstract public function order(Cart $cart, SalesChannelContext $context, RequestDataBag $data): CartOrderRouteResponse;
}
