<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Product\SalesChannel;

use HeyFrame\Core\Content\Product\Aggregate\ProductVisibility\ProductVisibilityDefinition;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Filter\MultiFilter;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Filter\RangeFilter;
use HeyFrame\Core\Framework\Log\Package;

/**
 * @final
 */
#[Package('inventory')]
class ProductAvailableFilter extends MultiFilter
{
    public function __construct(
        private readonly string $salesChannelId,
        private readonly int $visibility = ProductVisibilityDefinition::VISIBILITY_ALL
    ) {
        parent::__construct(
            self::CONNECTION_AND,
            [
                new RangeFilter('product.visibilities.visibility', [RangeFilter::GTE => $visibility]),
                new EqualsFilter('product.visibilities.salesChannelId', $salesChannelId),
                new EqualsFilter('product.active', true),
            ]
        );
    }

    public function getSalesChannelId(): string
    {
        return $this->salesChannelId;
    }

    public function getVisibility(): int
    {
        return $this->visibility;
    }
}
