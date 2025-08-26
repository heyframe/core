<?php declare(strict_types=1);

namespace HeyFrame\Core\System\SalesChannel\Event;

use HeyFrame\Core\Framework\Context;
use HeyFrame\Core\Framework\Event\HeyFrameSalesChannelEvent;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Validation\DataBag\RequestDataBag;
use HeyFrame\Core\Framework\Validation\DataValidationDefinition;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

#[Package('framework')]
class SwitchContextEvent implements HeyFrameSalesChannelEvent
{
    public const CONSISTENT_CHECK = self::class . '.consistent_check';
    public const DATABASE_CHECK = self::class . '.database_check';

    /**
     * @param array<string, mixed> $parameters
     */
    public function __construct(
        private readonly RequestDataBag $requestData,
        private readonly SalesChannelContext $salesChannelContext,
        private readonly DataValidationDefinition $dataValidationDefinition,
        private array $parameters,
    ) {
    }

    public function getRequestData(): RequestDataBag
    {
        return $this->requestData;
    }

    public function getSalesChannelContext(): SalesChannelContext
    {
        return $this->salesChannelContext;
    }

    public function getContext(): Context
    {
        return $this->salesChannelContext->getContext();
    }

    public function getDataValidationDefinition(): DataValidationDefinition
    {
        return $this->dataValidationDefinition;
    }

    /**
     * @return array<string, mixed>
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function addParameter(string $key, mixed $value): void
    {
        $this->parameters[$key] = $value;
    }

    public function deleteParameter(string $key): void
    {
        unset($this->parameters[$key]);
    }
}
