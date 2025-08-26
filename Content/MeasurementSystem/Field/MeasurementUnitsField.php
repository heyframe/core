<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\MeasurementSystem\Field;

use HeyFrame\Core\Framework\DataAbstractionLayer\Field\ObjectField;
use HeyFrame\Core\Framework\Log\Package;

#[Package('inventory')]
class MeasurementUnitsField extends ObjectField
{
    protected function getSerializerClass(): string
    {
        return MeasurementUnitsFieldSerializer::class;
    }
}
