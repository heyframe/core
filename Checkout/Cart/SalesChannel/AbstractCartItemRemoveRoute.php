<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Cart\SalesChannel;

use HeyFrame\Core\Checkout\Cart\Cart;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpFoundation\Request;

/**
 * This route can be used to remove line items from cart
 */
#[Package('checkout')]
abstract class AbstractCartItemRemoveRoute
{
    abstract public function getDecorated(): AbstractCartItemRemoveRoute;

    abstract public function remove(Request $request, Cart $cart, SalesChannelContext $context): CartResponse;
}
