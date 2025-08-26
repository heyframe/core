<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Customer\SalesChannel;

use HeyFrame\Core\Checkout\Customer\CustomerEntity;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Validation\DataBag\RequestDataBag;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;
use HeyFrame\Core\System\SalesChannel\SuccessResponse;

/**
 * This route is used to change the email of a logged-in user
 * The required fields are: "password", "email" and "emailConfirmation"
 */
#[Package('checkout')]
abstract class AbstractChangeEmailRoute
{
    abstract public function getDecorated(): AbstractChangeEmailRoute;

    abstract public function change(RequestDataBag $requestDataBag, SalesChannelContext $context, CustomerEntity $customer): SuccessResponse;
}
