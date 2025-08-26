<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Customer\SalesChannel;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Validation\DataBag\RequestDataBag;
use HeyFrame\Core\System\SalesChannel\ContextTokenResponse;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

/**
 * This route can be used to logout the current context token
 */
#[Package('checkout')]
abstract class AbstractLogoutRoute
{
    abstract public function getDecorated(): AbstractLogoutRoute;

    abstract public function logout(SalesChannelContext $context, RequestDataBag $data): ContextTokenResponse;
}
