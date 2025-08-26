<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Customer\Event;

use HeyFrame\Core\Checkout\Customer\Aggregate\CustomerRecovery\CustomerRecoveryEntity;
use HeyFrame\Core\Framework\Context;
use HeyFrame\Core\Framework\Event\HeyFrameSalesChannelEvent;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Contracts\EventDispatcher\Event;

#[Package('checkout')]
class PasswordRecoveryUrlEvent extends Event implements HeyFrameSalesChannelEvent
{
    public function __construct(
        private readonly SalesChannelContext $salesChannelContext,
        private string $recoveryUrl,
        private readonly string $hash,
        private readonly string $storefrontUrl,
        private readonly CustomerRecoveryEntity $customerRecovery
    ) {
    }

    public function getRecoveryUrl(): string
    {
        return $this->recoveryUrl;
    }

    public function setRecoveryUrl(string $recoveryUrl): void
    {
        $this->recoveryUrl = $recoveryUrl;
    }

    public function getSalesChannelContext(): SalesChannelContext
    {
        return $this->salesChannelContext;
    }

    public function getContext(): Context
    {
        return $this->salesChannelContext->getContext();
    }

    public function getSalesChannelId(): string
    {
        return $this->salesChannelContext->getSalesChannelId();
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function getStorefrontUrl(): string
    {
        return $this->storefrontUrl;
    }

    public function getCustomerRecovery(): CustomerRecoveryEntity
    {
        return $this->customerRecovery;
    }
}
