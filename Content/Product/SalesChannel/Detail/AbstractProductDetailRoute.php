<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Product\SalesChannel\Detail;

use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Criteria;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpFoundation\Request;

#[Package('inventory')]
abstract class AbstractProductDetailRoute
{
    abstract public function getDecorated(): AbstractProductDetailRoute;

    abstract public function load(string $productId, Request $request, SalesChannelContext $context, Criteria $criteria): ProductDetailRouteResponse;
}
