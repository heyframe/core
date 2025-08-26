<?php declare(strict_types=1);

namespace HeyFrame\Core\Framework\Gateway\Context\Command\Struct;

use HeyFrame\Core\Checkout\Cart\Cart;
use HeyFrame\Core\Framework\App\Payload\Source;
use HeyFrame\Core\Framework\App\Payload\SourcedPayloadInterface;
use HeyFrame\Core\Framework\Context;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Struct\Struct;
use HeyFrame\Core\Framework\Validation\DataBag\RequestDataBag;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

/**
 * @internal
 */
#[Package('framework')]
class ContextGatewayPayloadStruct extends Struct implements SourcedPayloadInterface
{
    protected Source $source;

    public function __construct(
        protected Cart $cart,
        protected SalesChannelContext $salesChannelContext,
        protected RequestDataBag $data = new RequestDataBag(),
    ) {
    }

    public function getCart(): Cart
    {
        return $this->cart;
    }

    public function getSalesChannelContext(): SalesChannelContext
    {
        return $this->salesChannelContext;
    }

    public function getContext(): Context
    {
        return $this->salesChannelContext->getContext();
    }

    public function getData(): RequestDataBag
    {
        return $this->data;
    }

    public function setSource(Source $source): void
    {
        $this->source = $source;
    }
}
