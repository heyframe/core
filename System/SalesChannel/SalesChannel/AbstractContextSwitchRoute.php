<?php declare(strict_types=1);

namespace HeyFrame\Core\System\SalesChannel\SalesChannel;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Validation\DataBag\RequestDataBag;
use HeyFrame\Core\System\SalesChannel\ContextTokenResponse;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

/**
 * This route allows changing configurations inside the context.
 * Following parameters are allowed to change: "currencyId", "languageId", "billingAddressId", "shippingAddressId",
 * "paymentMethodId", "shippingMethodId", "countryId" and "countryStateId"
 */
#[Package('framework')]
abstract class AbstractContextSwitchRoute
{
    abstract public function getDecorated(): AbstractContextSwitchRoute;

    abstract public function switchContext(RequestDataBag $data, SalesChannelContext $context): ContextTokenResponse;
}
