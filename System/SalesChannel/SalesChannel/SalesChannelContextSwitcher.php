<?php declare(strict_types=1);

namespace HeyFrame\Core\System\SalesChannel\SalesChannel;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Validation\DataBag\DataBag;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

#[Package('framework')]
class SalesChannelContextSwitcher
{
    /**
     * @internal
     */
    public function __construct(private readonly AbstractContextSwitchRoute $contextSwitchRoute)
    {
    }

    public function update(DataBag $data, SalesChannelContext $context): void
    {
        $this->contextSwitchRoute->switchContext($data->toRequestDataBag(), $context);
    }
}
