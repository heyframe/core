<?php declare(strict_types=1);

namespace HeyFrame\Core\Framework\Gateway\Context\SalesChannel;

use HeyFrame\Core\Checkout\Cart\Cart;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\ContextTokenResponse;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpFoundation\Request;

#[Package('framework')]
abstract class AbstractContextGatewayRoute
{
    abstract public function getDecorated(): AbstractContextGatewayRoute;

    abstract public function load(Request $request, Cart $cart, SalesChannelContext $context): ContextTokenResponse;
}
