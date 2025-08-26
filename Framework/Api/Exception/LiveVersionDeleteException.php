<?php declare(strict_types=1);

namespace HeyFrame\Core\Framework\Api\Exception;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\HeyFrameHttpException;

#[Package('framework')]
class LiveVersionDeleteException extends HeyFrameHttpException
{
    public function __construct()
    {
        parent::__construct('Live version can not be deleted. Delete entity instead.');
    }

    public function getErrorCode(): string
    {
        return 'FRAMEWORK__LIVE_VERSION_DELETE';
    }
}
