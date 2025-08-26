<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Sitemap\Service;

use HeyFrame\Core\Content\Sitemap\Struct\Sitemap;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

#[Package('discovery')]
interface SitemapListerInterface
{
    /**
     * @return Sitemap[]
     */
    public function getSitemaps(SalesChannelContext $salesChannelContext): array;
}
