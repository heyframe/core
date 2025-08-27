<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Cms\Events;

use HeyFrame\Core\Content\Cms\CmsPageCollection;
use HeyFrame\Core\Framework\Context;
use HeyFrame\Core\Framework\DataAbstractionLayer\EntityCollection;
use HeyFrame\Core\Framework\Event\HeyFrameSalesChannelEvent;
use HeyFrame\Core\Framework\Event\NestedEvent;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpFoundation\Request;

#[Package('discovery')]
class CmsPageLoadedEvent extends NestedEvent implements HeyFrameSalesChannelEvent
{
    protected Request $request;

    protected CmsPageCollection $result;

    protected SalesChannelContext $salesChannelContext;

    /**
     * @param CmsPageCollection $result
     */
    public function __construct(
        Request $request,
        EntityCollection $result,
        SalesChannelContext $salesChannelContext
    ) {
        $this->request = $request;
        $this->result = $result;
        $this->salesChannelContext = $salesChannelContext;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @return CmsPageCollection
     */
    public function getResult(): EntityCollection
    {
        return $this->result;
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
