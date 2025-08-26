<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\ProductExport\Event;

use HeyFrame\Core\Content\ProductExport\ProductExportEntity;
use HeyFrame\Core\Content\ProductExport\Struct\ExportBehavior;
use HeyFrame\Core\Framework\Context;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Criteria;
use HeyFrame\Core\Framework\Event\NestedEvent;
use HeyFrame\Core\Framework\Event\HeyFrameSalesChannelEvent;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

#[Package('inventory')]
class ProductExportProductCriteriaEvent extends NestedEvent implements HeyFrameSalesChannelEvent
{
    public function __construct(
        protected Criteria $criteria,
        protected ProductExportEntity $productExport,
        protected ExportBehavior $exportBehaviour,
        protected SalesChannelContext $salesChannelContext
    ) {
    }

    public function getCriteria(): Criteria
    {
        return $this->criteria;
    }

    public function getProductExport(): ProductExportEntity
    {
        return $this->productExport;
    }

    public function getExportBehaviour(): ExportBehavior
    {
        return $this->exportBehaviour;
    }

    public function getContext(): Context
    {
        return $this->salesChannelContext->getContext();
    }

    public function getSalesChannelContext(): SalesChannelContext
    {
        return $this->salesChannelContext;
    }
}
