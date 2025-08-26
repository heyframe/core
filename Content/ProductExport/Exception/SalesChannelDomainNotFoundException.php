<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\ProductExport\Exception;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\HeyFrameHttpException;

#[Package('inventory')]
class SalesChannelDomainNotFoundException extends HeyFrameHttpException
{
    public function __construct(string $id)
    {
        parent::__construct('Sales channel domain with ID {{ id }} not found', ['id' => $id]);
    }

    public function getErrorCode(): string
    {
        return 'CONTENT__PRODUCT_EXPORT_SALES_CHANNEL_DOMAIN_NOT_FOUND';
    }
}
