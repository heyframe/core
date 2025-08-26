<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Customer\SalesChannel;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Validation\DataBag\RequestDataBag;
use HeyFrame\Core\System\SalesChannel\ContextTokenResponse;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

/**
 * This route is used to login and get a new context token
 * The required parameters are "email" and "password"
 */
#[Package('checkout')]
abstract class AbstractLoginRoute
{
    abstract public function getDecorated(): AbstractLoginRoute;

    abstract public function login(RequestDataBag $data, SalesChannelContext $context): ContextTokenResponse;
}
