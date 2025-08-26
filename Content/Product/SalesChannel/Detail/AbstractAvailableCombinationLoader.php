<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Product\SalesChannel\Detail;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

#[Package('inventory')]
abstract class AbstractAvailableCombinationLoader
{
    abstract public function getDecorated(): AbstractAvailableCombinationLoader;

    abstract public function loadCombinations(string $productId, SalesChannelContext $salesChannelContext): AvailableCombinationResult;
}
