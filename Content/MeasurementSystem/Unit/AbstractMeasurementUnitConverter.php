<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\MeasurementSystem\Unit;

use HeyFrame\Core\Framework\Log\Package;

#[Package('inventory')]
abstract class AbstractMeasurementUnitConverter
{
    abstract public function getDecorated(): AbstractMeasurementUnitConverter;

    abstract public function convert(float $value, string $fromUnit, string $toUnit, ?int $precision = null): ConvertedUnit;
}
