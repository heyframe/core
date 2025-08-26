<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Breadcrumb\SalesChannel;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpFoundation\Request;

#[Package('inventory')]
abstract class AbstractBreadcrumbRoute
{
    abstract public function getDecorated(): AbstractBreadcrumbRoute;

    abstract public function load(Request $request, SalesChannelContext $salesChannelContext): BreadcrumbRouteResponse;
}
