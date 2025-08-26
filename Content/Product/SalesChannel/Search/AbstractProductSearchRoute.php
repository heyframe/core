<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Product\SalesChannel\Search;

use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Criteria;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpFoundation\Request;

/**
 * This route is used for the product search in the search pages
 */
#[Package('inventory')]
abstract class AbstractProductSearchRoute
{
    abstract public function getDecorated(): AbstractProductSearchRoute;

    abstract public function load(Request $request, SalesChannelContext $context, Criteria $criteria): ProductSearchRouteResponse;
}
