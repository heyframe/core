<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\MeasurementSystem\Unit;

use HeyFrame\Core\Framework\Log\Package;

#[Package('inventory')]
class ConvertedUnit
{
    public function __construct(public readonly float $value, public readonly string $unit)
    {
    }
}
