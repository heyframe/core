<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Customer\SalesChannel;

use HeyFrame\Core\Checkout\Customer\CustomerEntity;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Criteria;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpFoundation\Request;

/**
 * This route is used to get information about the current logged-in customer
 */
#[Package('checkout')]
abstract class AbstractCustomerRoute
{
    abstract public function getDecorated(): AbstractCustomerRoute;

    abstract public function load(Request $request, SalesChannelContext $context, Criteria $criteria, CustomerEntity $customer): CustomerResponse;
}
