<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Product\SalesChannel;

use HeyFrame\Core\Content\Product\ProductCollection;
use HeyFrame\Core\Framework\Log\Package;

#[Package('inventory')]
class SalesChannelProductCollection extends ProductCollection
{
    protected function getExpectedClass(): string
    {
        return SalesChannelProductEntity::class;
    }
}
