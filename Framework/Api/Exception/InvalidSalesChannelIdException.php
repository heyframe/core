<?php declare(strict_types=1);

namespace HeyFrame\Core\Framework\Api\Exception;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\HeyFrameHttpException;
use Symfony\Component\HttpFoundation\Response;

#[Package('framework')]
class InvalidSalesChannelIdException extends HeyFrameHttpException
{
    public function __construct(string $salesChannelId)
    {
        parent::__construct(
            'The provided salesChannelId "{{ salesChannelId }}" is invalid.',
            ['salesChannelId' => $salesChannelId]
        );
    }

    public function getErrorCode(): string
    {
        return 'FRAMEWORK__INVALID_SALES_CHANNEL';
    }

    public function getStatusCode(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }
}
