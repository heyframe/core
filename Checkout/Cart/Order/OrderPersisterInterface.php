<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Cart\Order;

use HeyFrame\Core\Checkout\Cart\Cart;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

#[Package('checkout')]
interface OrderPersisterInterface
{
    public function persist(Cart $cart, SalesChannelContext $context): string;
}
