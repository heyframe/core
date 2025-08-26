<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Customer\SalesChannel;

use HeyFrame\Core\Checkout\Customer\CustomerEntity;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\NoContentResponse;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

/**
 * This route can be used to delete a customer
 */
#[Package('checkout')]
abstract class AbstractDeleteCustomerRoute
{
    abstract public function getDecorated(): AbstractDeleteCustomerRoute;

    abstract public function delete(SalesChannelContext $context, CustomerEntity $customer): NoContentResponse;
}
