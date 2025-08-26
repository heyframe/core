<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Product\SalesChannel;

use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Criteria;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

/**
 * This route is a general route to get products of the sales channel
 */
#[Package('inventory')]
abstract class AbstractProductListRoute
{
    abstract public function getDecorated(): AbstractProductListRoute;

    abstract public function load(Criteria $criteria, SalesChannelContext $context): ProductListResponse;
}
