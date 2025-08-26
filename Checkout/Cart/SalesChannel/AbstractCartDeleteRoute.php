<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Cart\SalesChannel;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\NoContentResponse;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

/**
 * This route can be used to delete the entire cart
 */
#[Package('checkout')]
abstract class AbstractCartDeleteRoute
{
    abstract public function getDecorated(): AbstractCartDeleteRoute;

    abstract public function delete(SalesChannelContext $context): NoContentResponse;
}
