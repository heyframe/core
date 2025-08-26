<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Customer\SalesChannel;

use HeyFrame\Core\Checkout\Customer\CustomerEntity;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Validation\DataBag\RequestDataBag;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;
use HeyFrame\Core\System\SalesChannel\SuccessResponse;

/**
 * This route is used to change the language of a logged-in user
 * The required field is: "languageId"
 */
#[Package('checkout')]
abstract class AbstractChangeLanguageRoute
{
    abstract public function getDecorated(): AbstractChangeLanguageRoute;

    abstract public function change(RequestDataBag $requestDataBag, SalesChannelContext $context, CustomerEntity $customer): SuccessResponse;
}
