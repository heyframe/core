<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Customer\SalesChannel;

use HeyFrame\Core\Checkout\Customer\CustomerEntity;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Criteria;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

/**
 * This route can be used to list all addresses of an customer
 */
#[Package('checkout')]
abstract class AbstractListAddressRoute
{
    abstract public function load(Criteria $criteria, SalesChannelContext $context, CustomerEntity $customer): ListAddressRouteResponse;

    abstract public function getDecorated(): AbstractListAddressRoute;
}
