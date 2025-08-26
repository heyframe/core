<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Product\SalesChannel;

use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Filter\MultiFilter;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

#[Package('inventory')]
abstract class AbstractProductCloseoutFilterFactory
{
    abstract public function getDecorated(): AbstractProductCloseoutFilterFactory;

    abstract public function create(SalesChannelContext $context): MultiFilter;
}
