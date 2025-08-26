<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Customer\SalesChannel;

use HeyFrame\Core\Checkout\Customer\CustomerEntity;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\NoContentResponse;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

/**
 * This route can be used to delete addresses
 */
#[Package('checkout')]
abstract class AbstractDeleteAddressRoute
{
    abstract public function getDecorated(): AbstractDeleteAddressRoute;

    abstract public function delete(string $addressId, SalesChannelContext $context, CustomerEntity $customer): NoContentResponse;
}
