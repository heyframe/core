<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\MeasurementSystem\Unit;

use HeyFrame\Core\Content\MeasurementSystem\DataAbstractionLayer\MeasurementDisplayUnitEntity;
use HeyFrame\Core\Framework\Log\Package;

#[Package('inventory')]
abstract class AbstractMeasurementUnitProvider
{
    abstract public function getDecorated(): AbstractMeasurementUnitProvider;

    abstract public function getUnitInfo(string $unit): MeasurementDisplayUnitEntity;
}
