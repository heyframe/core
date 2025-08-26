<?php declare(strict_types=1);

namespace HeyFrame\Core\Framework\Api\Context;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Struct\JsonSerializableTrait;

#[Package('framework')]
class SalesChannelApiSource implements ContextSource, \JsonSerializable
{
    use JsonSerializableTrait;

    public string $type = 'sales-channel';

    public function __construct(private readonly string $salesChannelId)
    {
    }

    public function getSalesChannelId(): string
    {
        return $this->salesChannelId;
    }
}
