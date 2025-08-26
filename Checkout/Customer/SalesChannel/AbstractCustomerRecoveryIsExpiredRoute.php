<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Customer\SalesChannel;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Validation\DataBag\RequestDataBag;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

/**
 * This route is used get the CustomerRecoveryIsExpiredResponse entry for a given hash
 * The required parameter is: "hash"
 */
#[Package('checkout')]
abstract class AbstractCustomerRecoveryIsExpiredRoute
{
    abstract public function getDecorated(): AbstractCustomerRecoveryIsExpiredRoute;

    abstract public function load(RequestDataBag $data, SalesChannelContext $context): CustomerRecoveryIsExpiredResponse;
}
