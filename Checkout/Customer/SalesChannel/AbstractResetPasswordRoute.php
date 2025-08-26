<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Customer\SalesChannel;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Validation\DataBag\RequestDataBag;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;
use HeyFrame\Core\System\SalesChannel\SuccessResponse;

/**
 * This route is used handle the password reset form
 * The required parameters are: "hash" (received from the mail), "newPassword" and "newPasswordConfirm"
 */
#[Package('checkout')]
abstract class AbstractResetPasswordRoute
{
    abstract public function getDecorated(): AbstractResetPasswordRoute;

    abstract public function resetPassword(RequestDataBag $data, SalesChannelContext $context): SuccessResponse;
}
