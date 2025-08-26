<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Customer\SalesChannel;

use HeyFrame\Core\Checkout\Customer\CustomerEntity;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Validation\DataBag\RequestDataBag;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;
use HeyFrame\Core\System\SalesChannel\SuccessResponse;

/**
 * This route can be used to merge wishlist products from guest users to registered users.
 */
#[Package('checkout')]
abstract class AbstractMergeWishlistProductRoute
{
    abstract public function getDecorated(): AbstractMergeWishlistProductRoute;

    abstract public function merge(RequestDataBag $data, SalesChannelContext $context, CustomerEntity $customer): SuccessResponse;
}
