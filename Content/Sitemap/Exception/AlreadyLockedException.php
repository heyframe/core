<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Sitemap\Exception;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\HeyFrameHttpException;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

#[Package('discovery')]
class AlreadyLockedException extends HeyFrameHttpException
{
    public function __construct(SalesChannelContext $salesChannelContext)
    {
        parent::__construct('Cannot acquire lock for sales channel {{salesChannelId}} and language {{languageId}}', [
            'salesChannelId' => $salesChannelContext->getSalesChannelId(),
            'languageId' => $salesChannelContext->getLanguageId(),
        ]);
    }

    public function getErrorCode(): string
    {
        return 'CONTENT__SITEMAP_ALREADY_LOCKED';
    }
}
