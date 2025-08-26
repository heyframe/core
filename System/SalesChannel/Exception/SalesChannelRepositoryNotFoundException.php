<?php declare(strict_types=1);

namespace HeyFrame\Core\System\SalesChannel\Exception;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\HeyFrameHttpException;

#[Package('discovery')]
class SalesChannelRepositoryNotFoundException extends HeyFrameHttpException
{
    public function __construct(string $entity)
    {
        parent::__construct(
            'SalesChannelRepository for entity "{{ entityName }}" does not exist.',
            ['entityName' => $entity]
        );
    }

    public function getErrorCode(): string
    {
        return 'FRAMEWORK__SALES_CHANNEL_REPOSITORY_NOT_FOUND';
    }
}
