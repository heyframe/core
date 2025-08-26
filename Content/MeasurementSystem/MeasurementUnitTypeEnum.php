<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\MeasurementSystem;

use HeyFrame\Core\Framework\Log\Package;

/**
 * @internal
 *
 * @codeCoverageIgnore
 */
#[Package('inventory')]
enum MeasurementUnitTypeEnum: string
{
    case LENGTH = 'length';
    case WEIGHT = 'weight';
}
