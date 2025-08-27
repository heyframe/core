<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\ProductExport\Exception;

use HeyFrame\Core\Framework\HeyFrameHttpException;
use HeyFrame\Core\Framework\Log\Package;

#[Package('inventory')]
class MissingRootFilterException extends HeyFrameHttpException
{
    public function __construct()
    {
        parent::__construct('Missing root filter ');
    }

    public function getErrorCode(): string
    {
        return 'CONTENT__PRODUCT_EXPORT_EMPTY';
    }
}
