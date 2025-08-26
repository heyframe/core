<?php declare(strict_types=1);

namespace HeyFrame\Core\Framework\DataAbstractionLayer\Write\FieldException;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\HeyFrameException;

#[Package('framework')]
interface WriteFieldException extends HeyFrameException
{
    public function getPath(): string;
}
