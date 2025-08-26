<?php declare(strict_types=1);

namespace HeyFrame\Core\System\UsageData\Consent;

use HeyFrame\Core\Framework\Log\Package;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * @internal
 */
#[Package('data-services')]
class ConsentStateChangedEvent extends Event
{
    public function __construct(private readonly ConsentState $state)
    {
    }

    public function getState(): ConsentState
    {
        return $this->state;
    }
}
