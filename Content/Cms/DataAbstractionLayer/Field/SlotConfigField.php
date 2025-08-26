<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Cms\DataAbstractionLayer\Field;

use HeyFrame\Core\Content\Cms\DataAbstractionLayer\FieldSerializer\SlotConfigFieldSerializer;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\JsonField;
use HeyFrame\Core\Framework\Log\Package;

#[Package('discovery')]
class SlotConfigField extends JsonField
{
    public function __construct(
        string $storageName,
        string $propertyName
    ) {
        $this->storageName = $storageName;
        parent::__construct($storageName, $propertyName);
    }

    protected function getSerializerClass(): string
    {
        return SlotConfigFieldSerializer::class;
    }
}
